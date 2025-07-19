<?php

namespace Nirbose\PhpMcServ\World;

class Region
{
    private string $filePath;
    private array $chunks = []; // [chunkX][chunkZ] => Chunk

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->loadChunks();
    }

    private function loadChunks(): void
    {
        $reader = new ChunkParser($this->filePath);
        $this->chunks = $reader->parseAll();
    }

    public function getChunk(int $x, int $z): ?Chunk
    {
        return $this->chunks[$x][$z] ?? null;
    }
}