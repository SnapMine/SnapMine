<?php

namespace SnapMine\Manager\ChunkManager;

use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\World;
use function Amp\Parallel\Worker\getWorker;

class ChunkManager
{
    public function __construct()
    {
    }

    public function request(Player $player, World $world, int $x, int $z): void
    {
        getWorker()
            ->submit(new ChunkTask($world, $x, $z))
            ->getFuture()
            ->map(function (Chunk $chunk) use ($player) {
                $player->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));
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

