<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\IO\Reader\ZLibCompressedStringReader;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\Tag;
use Error;
use Nirbose\PhpMcServ\World\Chunk\Chunk;

class Region
{
    /** @var resource */
    private $handle;
    private string $offsetTable;
    /** @var array<int, array<int, Chunk>> $chunks */
    private array $chunks = []; // [chunkX][chunkZ] => Chunk

    public function __construct(string $file)
    {
        $this->handle = fopen($file, 'rb');
        if (!$this->handle) {
            throw new Error("Cannot open: $file");
        }

        $this->offsetTable = fread($this->handle, 4096);
        if (!$this->offsetTable || strlen($this->offsetTable) < 4096) {
            throw new Error("Invalid region file: $file");
        }
    }

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
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
}