<?php

namespace Nirbose\PhpMcServ\Manager;

use Amp\Cancellation;
use Amp\Parallel\Worker\Task;
use Amp\Sync\Channel;
use Nirbose\PhpMcServ\World\Chunk\Chunk;
use Nirbose\PhpMcServ\World\World;

readonly class ChunkTask implements Task
{
    public function __construct(private int $x, private int $z, private World $world)
    {}

    /**
     * @inheritDoc
     */
    public function run(Channel $channel, Cancellation $cancellation): ?Chunk
    {
        return $this->world->getChunk($this->x, $this->z);
    }
}