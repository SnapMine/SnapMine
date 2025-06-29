<?php

namespace Nirbose\PhpMcServ\Tick;

use Nirbose\PhpMcServ\Server;

class TickManager {
    private float $lastTick;
    private int $tickRate = 20; // 20 ticks/sec
    private int $tickInterval; // In microseconds (ms)
    private bool $running = false;

    public function __construct() {
        $this->tickInterval = (int)(1_000_000 / $this->tickRate); // 50_000 ms
    }

    public function start(): void {
        $this->running = true;
        $this->lastTick = microtime(true);

        while ($this->running) {
            $tickStart = microtime(true);

            $tickDuration = microtime(true) - $tickStart;
            $sleepTime = max(0, $this->tickInterval - ($tickDuration * 1_000_000));

            usleep((int)$sleepTime);
        }
    }

    public function stop(): void {
        $this->running = false;
    }
}