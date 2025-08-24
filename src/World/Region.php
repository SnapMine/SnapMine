<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\IO\Reader\GZipCompressedStringReader;
use Aternos\Nbt\IO\Reader\StringReader;
use Aternos\Nbt\IO\Reader\ZLibCompressedStringReader;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\Tag;
use Error;
use Nirbose\PhpMcServ\World\Chunk\Chunk;
use PHPUnit\Framework\Exception;
use function React\Async\async;
use function React\Async\await;
use function React\Promise\all;

class Region
{
    private string $file;
    private string $offsetTable;
    /** @var resource|null */
    private $handle = null;
    /** @var array<int, array<int, Chunk>> */
    private array $chunks = [];

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->openHandle();

        $this->offsetTable = fread($this->handle, 4096);
        if (!$this->offsetTable || strlen($this->offsetTable) < 4096) {
            throw new Error("Invalid region file: $file");
        }
    }

    private function openHandle(): void
    {
        if ($this->handle === null) {
            $this->handle = fopen($this->file, 'rb');
            if (!$this->handle) {
                throw new Error("Cannot open: {$this->file}");
            }
        }
    }

    private function closeHandle(): void
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
        $this->handle = null;
    }

    public function __destruct()
    {
        $this->closeHandle();
    }

    public function getChunk(int $x, int $z): ?Chunk
    {
        if ($x < 0 || $x >= 32 || $z < 0 || $z >= 32) {
            throw new Error("Invalid local coordinates ($x, $z)");
        }

        if (isset($this->chunks[$x][$z])) {
            return $this->chunks[$x][$z];
        }

        $i = $x + $z * 32;
        $entryOffset = $i * 4;

        $offset = unpack(
            'N',
            "\x00" .
            $this->offsetTable[$entryOffset] .
            $this->offsetTable[$entryOffset + 1] .
            $this->offsetTable[$entryOffset + 2]
        )[1];
        $sectors = ord($this->offsetTable[$entryOffset + 3]);

        if ($offset === 0 || $sectors === 0) {
            return null; // empty chunk
        }

        $this->openHandle();

        fseek($this->handle, $offset * 4096);
        $lengthData = fread($this->handle, 4);
        if ($lengthData === false || strlen($lengthData) < 4) {
            return null;
        }
        $length = unpack('N', $lengthData)[1];

        $compressionType = ord(fread($this->handle, 1));
        $compressedData = fread($this->handle, $length - 1);

        if ($compressionType === 2 && $compressedData !== false) {
            $reader = new ZLibCompressedStringReader($compressedData, NbtFormat::JAVA_EDITION);
            $nbt = Tag::load($reader);

            if ($nbt instanceof CompoundTag) {
                $chunkX = $nbt->getInt('xPos')->getValue();
                $chunkZ = $nbt->getInt('zPos')->getValue();

                $this->chunks[$x][$z] = (new Chunk($chunkX, $chunkZ))->loadFromNbt($nbt);

                return $this->chunks[$x][$z];
            }
        }

        return null;
    }



    /**
     * Charge les chunks d'un rectangle [x0..x1] × [z0..z1] (coords locales 0..31) en minimisant les I/O.
     * @return array<int, array<int, ?Chunk>>  indexé [z][x]
     */
    public function loadArea(int $x0, int $z0, int $x1, int $z1): array
    {
        // Clamp + ordre
        $x0 = max(0, min(31, $x0)); $x1 = max(0, min(31, $x1));
        $z0 = max(0, min(31, $z0)); $z1 = max(0, min(31, $z1));
        if ($x0 > $x1) [$x0, $x1] = [$x1, $x0];
        if ($z0 > $z1) [$z0, $z1] = [$z1, $z0];

        $toRead = [];
        $out = [];
        $futures = [];

        // 1) Collecte des entrées à lire
        for ($z = $z0; $z <= $z1; $z++) {

            for ($x = $x0; $x <= $x1; $x++) {
                if (isset($this->chunks[$x][$z])) {
                    $out[] = $this->chunks[$x][$z];
                    continue;
                }
                $i = ($z << 5) | $x;
                $entryOffset = $i << 2;

                if (!isset($this->offsetTable[$entryOffset + 3])) {
                    $out[] = null;
                    continue;
                }

                // offset = 3 octets BE, sectors = 1 octet
                $off = (ord($this->offsetTable[$entryOffset]) << 16)
                    | (ord($this->offsetTable[$entryOffset + 1]) << 8)
                    |  ord($this->offsetTable[$entryOffset + 2]);
                $secs = ord($this->offsetTable[$entryOffset + 3]);

                if ($off === 0 || $secs === 0) {
                    $out[] = null; // chunk vide
                    continue;
                }

                $toRead[] = ['x'=>$x, 'z'=>$z, 'off'=>$off, 'secs'=>$secs];
            }
        }

        if (!$toRead) return $out;

        // 2) Tri par offset puis groupement en runs contigus
        usort($toRead, fn($a, $b) => $a['off'] <=> $b['off']);

        $runs = [];
        $cur = null;
        foreach ($toRead as $e) {
            if ($cur === null) {
                $cur = ['start'=>$e['off'], 'len'=>$e['secs'], 'chunks'=>[$e]];
                continue;
            }
            $expectedNext = $cur['start'] + $cur['len'];
            if ($e['off'] === $expectedNext) {
                // contigu au run courant
                $cur['len'] += $e['secs'];
                $cur['chunks'][] = $e;
            } else {
                $runs[] = $cur;
                $cur = ['start'=>$e['off'], 'len'=>$e['secs'], 'chunks'=>[$e]];
            }
        }
        if ($cur !== null) $runs[] = $cur;

        $this->openHandle();
        $stat = fstat($this->handle);
        if ($stat === false) return $out;
        $fileSize = $stat['size'];

        // 3) Lecture run par run, puis découpe + parse des chunks
        foreach ($runs as $run) {
            $runByteStart = $run['start'] * 4096;
            $runByteLen   = $run['len']   * 4096;
            if ($runByteStart + 5 > $fileSize) {
                // run incohérent → on skippe prudemment
                continue;
            }
            $maxReadable = min($runByteLen, $fileSize - $runByteStart);

            // lecture en un seul bloc
            // (stream_get_contents avec offset ne bouge pas le curseur; fallback fseek/fread)
            $buf = @stream_get_contents($this->handle, $maxReadable, $runByteStart);
            if ($buf === false || strlen($buf) < 5) {
                if (fseek($this->handle, $runByteStart) !== 0) continue;
                $buf = fread($this->handle, $maxReadable);
                if ($buf === false || strlen($buf) < 5) continue;
            }

            foreach ($run['chunks'] as $e) {
                $local = ($e['off'] - $run['start']) * 4096;
                $chunkSpan = $e['secs'] * 4096;

                if ($local < 0 || $local + 5 > strlen($buf)) {
                    $out[]= null;
                    continue;
                }

                $chunkSlice = substr($buf, $local, min($chunkSpan, strlen($buf) - $local));
                if (strlen($chunkSlice) < 5) { // 4 (length) + 1 (type)
                    $out[] = null;
                    continue;
                }

                $length = unpack('N', substr($chunkSlice, 0, 4))[1];
                if ($length < 1 || ($length + 4) > $chunkSpan || ($length + 4) > strlen($chunkSlice)) {
                    // longueur invalide ou dépassement des secteurs
                    $out[] = null;
                    continue;
                }

                $compType = ord($chunkSlice[4]);
                $payload  = substr($chunkSlice, 5, $length - 1);
                if (strlen($payload) !== ($length - 1)) {
                    $out[] = null;
                    continue;
                }

                try {
                    switch ($compType) {
                        case 2: // zlib
                            $reader = new ZLibCompressedStringReader($payload, NbtFormat::JAVA_EDITION);
                            break;
                        case 1: // gzip
                            if (class_exists(GZipCompressedStringReader::class)) {
                                $reader = new GZipCompressedStringReader($payload, NbtFormat::JAVA_EDITION);
                            } else {
                                $decoded = gzdecode($payload);
                                if ($decoded === false) { $out[$e['z']][$e['x']] = null; continue 2; }
                                $reader = new StringReader($decoded, NbtFormat::JAVA_EDITION);
                            }
                            break;
                        case 3: // non compressé
                            $reader = new StringReader($payload, NbtFormat::JAVA_EDITION);
                            break;
                        default:
                            //$out[$e['z']][$e['x']] = null; // non supporté
                            continue 2;
                    }

                    $nbt = Tag::load($reader);
                    if (!$nbt instanceof CompoundTag) {
                        //$out[]= null;
                        continue;
                    }

                    $chunkX = $nbt->getInt('xPos')->getValue();
                    $chunkZ = $nbt->getInt('zPos')->getValue();

                    // Sanity check
                    if ((($chunkX & 31) !== $e['x']) || (($chunkZ & 31) !== $e['z'])) {
                        //$out[] = null;
                        continue;
                    }

                    $futures[] = async(function () use ($chunkX, $chunkZ, $nbt) {
                        return (new Chunk($chunkX, $chunkZ))->loadFromNbt($nbt);
                    })();
                } catch (\Throwable $t) {
                    $out[] = null;
                }
            }
        }

        $chunks = await(all($futures));

        $this->chunks = array_merge($this->chunks, $chunks);
        return array_merge($out, $chunks);
    }




}