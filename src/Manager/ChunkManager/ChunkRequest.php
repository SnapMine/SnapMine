<?php

namespace Nirbose\PhpMcServ\Manager\ChunkManager;

use Nirbose\PhpMcServ\World\World;

class ChunkRequest
{
    protected ?\Closure $callback = null;
    public function __construct(
        protected World $world,
        protected int $x,
        protected int $z,
        ?callable $callback = null
    ) {
        $this->callback = $callback;
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

    public function getCallback(): ?\Closure
    {
        return $this->callback;
    }

    public function chunkExists(): bool
    {
        return $this->world->chunkExists($this->x, $this->z);
    }

}