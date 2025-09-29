<?php

namespace SnapMine\Manager\ChunkManager;

use React\EventLoop\Loop;
use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\World;

class ChunkManager
{
    private \SplQueue $chunkRequestQueue;
    private int $inflightChunks = 0;
    private int $maxInflightChunks = 4;

    public function __construct()
    {
        $this->chunkRequestQueue = new \SplQueue();
    }

    public function request(Player $player, World $world, int $x, int $z): void
    {
        $this->inflightChunks++;

        Loop::addTimer($this->inflightChunks / 10, function () use ($player, $world, $x, $z) {
//            if ($this->inflightChunks >= $this->maxInflightChunks) {
//                $this->chunkRequestQueue->enqueue([$player, $world, $x, $z]);
//                return;
//            }

//            $this->inflightChunks++;
            $world->getChunkAsync($x, $z)
                ->map(function (Chunk $chunk) use ($player) {
                    $player->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));

                    $this->inflightChunks--;
//                    if (!$this->chunkRequestQueue->isEmpty()) {
//                        [$p, $w, $nx, $nz] = $this->chunkRequestQueue->dequeue();
//                        $this->request($p, $w, $nx, $nz);
//                    }
                });
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

