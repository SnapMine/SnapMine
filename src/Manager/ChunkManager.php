<?php

namespace Nirbose\PhpMcServ\Manager;

use Amp\Future;
use Amp\Parallel\Worker\ContextWorkerPool;
use Amp\Parallel\Worker\WorkerPool;
use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Server;
use function Amp\Parallel\Worker\workerPool;

class ChunkManager implements Manager
{
    private array $chunks = [];
    private array $futures = [];
    private WorkerPool $pool;

    public function __construct()
    {
        $this->pool = workerPool(new ContextWorkerPool(1));
    }

    public function __destruct()
    {
        echo "Destructing chunk manager\n";
    }

    public function requestChunk(int $x, int $z, Player $player): void {
        $key = "$x:$z";

        if (isset($this->chunks[$key])) {
            $player->sendPacket(new ChunkDataAndUpdateLightPacket($this->chunks[$key]));
            return;
        }

        if (!isset($this->futures[$key])) {
            $future = $this->pool->submit(new ChunkTask($x, $z, Artisan::getServer()->getWorld("world")));

            $future = $future->getFuture();

            $future->map(function ($chunk) use ($player) {
                if (is_null($chunk)) {
                    return;
                }

                $player->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));
            });

            $this->futures[$key] = [
                'future' => $future,
                'players' => [$player],
            ];
        } else {
            $this->futures[$key]['players'][] = $player;
        }
    }

    public function tick(Server $server): void
    {
        foreach ($this->futures as $key => $data) {
            /** @var Future $future */
            $future = $data['future'];

            if ($future->isComplete()) {
                unset($this->futures[$key]);
            }
        }
    }
}