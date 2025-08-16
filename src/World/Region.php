<?php

namespace Nirbose\PhpMcServ\World;

use Nirbose\PhpMcServ\World\Chunk\Chunk;
use Nirbose\PhpMcServ\World\Chunk\ChunkParser;

class Region
{
    private ChunkParser $parser;
    /** @var array<int, array<int, Chunk>> $chunks */
    private array $chunks = []; // [chunkX][chunkZ] => Chunk

    public function __construct(string $filePath)
    {
        $this->parser = new ChunkParser($filePath);
    }

    public function getChunk(int $x, int $z): ?Chunk
    {
        if (!isset($this->chunks[$x][$z])) {
            $chunk = $this->parser->getChunk($x, $z);

            if (is_null($chunk))
                return null;

            $this->chunks[$x][$z] = $chunk;
        }

        return $this->chunks[$x][$z];
    }
}