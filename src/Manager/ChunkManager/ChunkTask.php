<?php

namespace SnapMine\Manager\ChunkManager;

use Amp\Cancellation;
use Amp\Parallel\Worker\Task;
use Amp\Sync\Channel;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\World;

class ChunkTask implements Task
{
    public function __construct(private readonly World $world, private int $x, private int $z)
    {
    }

    public function run(Channel $channel, Cancellation $cancellation): Chunk
    {
        return $this->world->getChunk($this->x, $this->z);
    }
}