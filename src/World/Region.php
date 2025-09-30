<?php

namespace SnapMine\World;

use Amp\Future;
use Amp\Parallel\Worker\Worker;
use Aternos\Nbt\IO\Reader\ZLibCompressedStringReader;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\Tag;
use Error;
use SnapMine\Manager\ChunkManager\ChunkTask;
use SnapMine\World\Chunk\Chunk;
use function Amp\Parallel\Worker\createWorker;

class Region
{
    /** @var array<int, array<int, Chunk>> */
    private array $chunks = [];
    private Worker $worker;

    public function __construct(private readonly World $world, private readonly string $file)
    {
        $this->worker = createWorker();
    }

    public function hasChunk(int $x, int $z): bool
    {
        if (isset($this->chunks[$x][$z])) {
            return true;
        }

        return false;
    }

    /**
     * @return Chunk[]
     */
    public function getLoadedChunks(): array
    {
        $chunks = [];
        for ($x = 0; $x < 32; $x++) {
            for ($z = 0; $z < 32; $z++) {
                if($this->hasChunk($x, $z)) {
                    $chunks[] = $this->getChunk($x, $z);
                }
            }
        }
        return $chunks;
    }

    public function getChunkAsync(int $x, int $z): Future
    {
        if ($x < 0 || $x >= 32 || $z < 0 || $z >= 32) {
            throw new Error("Invalid local coordinates ($x, $z)");
        }

        return $this->worker->submit(new ChunkTask(
            $this->file,
            $x,
            $z
        ))->getFuture()->map(function ($chunk) {
            $reader = new ZLibCompressedStringReader($chunk, NbtFormat::JAVA_EDITION);
            $tag = Tag::load($reader);

            if ($tag instanceof CompoundTag) {
                $chunk = Chunk::loadFromNbt($this->world, $tag);

                $this->chunks[$chunk->getX()][$chunk->getZ()] = $chunk;

                return $chunk;
            }

            return null;
        });
    }

    public function getChunk(int $x, int $z): Chunk
    {
        if ($this->hasChunk($x, $z)) {
            return $this->chunks[$x][$z];
        }

        return $this->getChunkAsync($x, $z)->await();
    }

}