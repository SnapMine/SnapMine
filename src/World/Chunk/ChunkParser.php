<?php

namespace Nirbose\PhpMcServ\World\Chunk;

use Aternos\Nbt\IO\Reader\ZLibCompressedStringReader;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\Tag;
use Exception;

class ChunkParser
{
    private string $file;
    /** @var resource */
    private $handle;
    private string $offsetTable;

    /**
     * @throws Exception
     */
    public function __construct(string $file)
    {
        $this->file = $file;
        $this->handle = fopen($file, 'rb');
        if (!$this->handle) {
            throw new Exception("Cannot open: $file");
        }

        $this->offsetTable = fread($this->handle, 4096);
        if ($this->offsetTable === false || strlen($this->offsetTable) < 4096) {
            throw new Exception("Invalid region file: $file");
        }
    }

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
     * @throws Exception
     */
    public function getChunk(int $localX, int $localZ): ?Chunk
    {
        if ($localX < 0 || $localX >= 32 || $localZ < 0 || $localZ >= 32) {
            throw new Exception("Invalid local coordinates ($localX, $localZ)");
        }

        $i = $localX + $localZ * 32;
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
            return null; // chunk vide
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

                return (new Chunk($chunkX, $chunkZ))->loadFromNbt($nbt);
            }
        }

        return null;
    }
}
