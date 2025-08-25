<?php

namespace SnapMine\Manager\ChunkManager;

use SnapMine\World\Chunk\Chunk;
use SnapMine\World\World;

class ChunkRequest
{
    /** @var callable[] */
    protected array $callbacks = [];
    public function __construct(
        protected World $world,
        protected int $x,
        protected int $z,
        ?callable $callback = null
    ) {

        $this->callbacks[] = $callback;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getZ(): int
    {
        return $this->z;
    }

    public function getWorld(): World
    {
        return $this->world;
    }

    public function getCallbacks(): array {
        return $this->callbacks;
    }

    public function runCallbacks(Chunk $chunk): void
    {
        foreach ($this->callbacks as $callback) {
            $callback($chunk);
        }
    }

    public function addCallbacks(array $callbacks): void
    {
        $this->callbacks = array_merge($this->callbacks, $callbacks);
    }

    public function exists(): bool
    {
        return $this->world->hasChunk($this->x, $this->z);
    }

}