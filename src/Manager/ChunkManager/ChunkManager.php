<?php

namespace SnapMine\Manager\ChunkManager;

use React\EventLoop\Loop;
use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\World;

class ChunkManager
{
    private array $queue = [];
    private int $chunksPerTick = 2;
    private bool $taskRegistered = false;

    public function request(Player $player, World $world, int $x, int $z): void {
        $this->queue[] = [
            'player' => $player,
            'world' => $world,
            'x' => $x,
            'z' => $z
        ];

        $this->ensureTaskRunning();
    }

    private function ensureTaskRunning(): void {
        if ($this->taskRegistered || empty($this->queue)) {
            return;
        }

        $this->taskRegistered = true;

        $handler = Loop::addPeriodicTimer(0.05, function () use (&$handler) {
            $sent = 0;

            while (!empty($this->queue) && $sent < $this->chunksPerTick) {
                $request = array_shift($this->queue);

                // Vérifie que le joueur est toujours connecté
                if (!$request['player']->isConnected()) {
                    continue;
                }

                $request['world']->getChunkAsync($request['x'], $request['z'])
                    ->map(function (Chunk $chunk) use ($request) {
                        $request['player']->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));
                    });

                $sent++;
            }

            if (empty($this->queue)) {
                Loop::cancelTimer($handler);
                $this->taskRegistered = false;
            }
        });
    }

    public function loadRadius(World $world, int $x, int $z, int $radius, Player $player, int $start = 1): void
    {
        for ($k = $start; $k <= $radius; $k++) {
            // côté haut : z = -k
            for ($dx = -$k + 1; $dx <= $k; $dx++) {
                $this->request($player, $world, $x + $dx, $z - $k);
            }
            // côté droit : x = +k
            for ($dz = -$k + 1; $dz <= $k; $dz++) {
                $this->request($player, $world, $x + $k, $z + $dz);
            }
            // côté bas : z = +k
            for ($dx = $k - 1; $dx >= -$k; $dx--) {
                $this->request($player, $world, $x + $dx, $z + $k);
            }
            // côté gauche : x = -k
            for ($dz = $k - 1; $dz >= -$k; $dz--) {
                $this->request($player, $world, $x - $k, $z + $dz);
            }
        }

    }

}

