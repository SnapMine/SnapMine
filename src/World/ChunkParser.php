<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\IO\Reader\ZLibCompressedStringReader;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\Tag;
use Exception;

class ChunkParser
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * @throws Exception
     */
    public function parseAll(): array
    {
        $chunks = [];
        $handle = fopen($this->file, 'rb');
        if (!$handle) throw new Exception("Cannot open: $this->file");

        $offsetTable = fread($handle, 4096);
        for ($i = 0; $i < 1024; $i++) {
            $entry = substr($offsetTable, $i * 4, 4);
            $offset = unpack('N', "\x00" . substr($entry, 0, 3))[1];
            $sectors = ord($entry[3]);

            if ($offset === 0 || $sectors === 0) continue;

            $chunkX = $i % 32;
            $chunkZ = intdiv($i, 32);
            fseek($handle, $offset * 4096);
            $length = unpack('N', fread($handle, 4))[1];
            $compression = ord(fread($handle, 1));
            $compressed = fread($handle, $length - 1);

            if ($compression === 2) {
                $reader = new ZLibCompressedStringReader($compressed, NbtFormat::JAVA_EDITION);
                $nbt = Tag::load($reader);
                $chunks[$chunkX][$chunkZ] = new Chunk($chunkX, $chunkZ, $nbt);
            }
        }

        fclose($handle);
        return $chunks;
    }
}