<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityPosPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;

class MovePlayerPositionPacket extends ServerboundPacket
{
    private float $x;
    private float $feetY;
    private float $z;
    /** @phpstan-ignore property.onlyWritten */
    private bool $flags;

    public function getId(): int
    {
        return 0x1C;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->x = $serializer->getDouble();
        $this->feetY = $serializer->getDouble();
        $this->z = $serializer->getDouble();
        $this->flags = $serializer->getBool();
    }

    public function handle(Session $session): void
    {
        $player = $session->getPlayer();
        $loc = $player->getLocation();

        $factor = 4096;

        $deltaX = (int)(($this->x - $loc->getX()) * $factor);
        $deltaY = (int)(($this->feetY - $loc->getY()) * $factor);
        $deltaZ = (int)(($this->z - $loc->getZ()) * $factor);

        $maxDelta = 32767; // max short
        if (abs($deltaX) > $maxDelta || abs($deltaY) > $maxDelta || abs($deltaZ) > $maxDelta) {
            // Utiliser TeleportEntityPacket à la place
            return;
        }

        $loc->setX($this->x);
        $loc->setY($this->feetY);
        $loc->setZ($this->z);

        $outPacket = new MoveEntityPosPacket(
            $player->getId(),
            $deltaX,
            $deltaY,
            $deltaZ,
            false
        );

        $player->getServer()->broadcastPacket($outPacket, fn (Player $p) => $p->getUuid() != $player->getUuid());
    }
}