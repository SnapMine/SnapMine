<?php

namespace Nirbose\PhpMcServ\Manager\ChunkManager;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\World\World;
use React\EventLoop\Loop;
use function React\Async\async;
use function React\Async\await;
use function React\Async\delay;

/**
 * Simple async-ish chunk loader with request queue and coalescing.
 * Note: IO is still synchronous; requests are scheduled over ticks
 * to avoid long bursts and to dedupe multiple callers.
 */
class ChunkManager
{
    private array $queues = [];
    private const QUEUE_COUNT = 2;
    public function __construct()
    {
        for ($i = 0; $i < self::QUEUE_COUNT; $i++) {
            $this->queues[] = [];

            Loop::addPeriodicTimer(0.0001, async(function () use ($i) {
                if(count($this->queues[$i]) > 0) {
                    $request = array_shift($this->queues[$i]);

                    //Artisan::getLogger()->info("Callback chunk {$request->getX()}, {$request->getZ()}");

                    $request->runCallbacks($request->getWorld()->getChunk($request->getX(), $request->getZ()));
                }
            }));




        }



    }

    public function addToQueue(ChunkRequest $request): void
    {
        // Artisan::getLogger()->info("Requesting chunk {$request->getX()}, {$request->getZ()}");
        if($request->exists()) {
            //Artisan::getLogger()->info("[CACHED] Callback chunk {$request->getX()}, {$request->getZ()}");
            $request->runCallbacks($request->getWorld()->getChunk($request->getX(), $request->getZ()));
            return;
        }
        $queue = $request->getX() + $request->getZ() & (self::QUEUE_COUNT - 1);

        foreach ($this->queues[$queue] as $queuedRequest) {
            if($queuedRequest->getX() == $request->getX() && $queuedRequest->getZ() == $request->getZ()) {
                $queuedRequest->addCallbacks($request->getCallbacks());
                return;
            }
        }

        //Artisan::getLogger()->info("Queueing chunk {$request->getX()}, {$request->getZ()} in queue $queue");
        $this->queues[$queue][] = $request;
    }


    public function loadRadius(World $world, int $x, int $z, int $radius, callable $callback, int $start = 1): void
    {
        for ($k = $start; $k <= $radius; $k++) {
            // côté haut : z = -k
            for ($dx = -$k + 1; $dx <= $k; $dx++) {
                $this->addToQueue(new ChunkRequest($world, $x + $dx, $z - $k, $callback));
            }
            // côté droit : x = +k
            for ($dz = -$k + 1; $dz <= $k; $dz++) {
                $this->addToQueue(new ChunkRequest($world, $x + $k, $z + $dz, $callback));
            }
            // côté bas : z = +k
            for ($dx = $k - 1; $dx >= -$k; $dx--) {
                $this->addToQueue(new ChunkRequest($world, $x + $dx, $z + $k, $callback));
            }
            // côté gauche : x = -k
            for ($dz = $k - 1; $dz >= -$k; $dz--) {
                $this->addToQueue(new ChunkRequest($world, $x - $k, $z + $dz, $callback));
            }
        }

    }

}

