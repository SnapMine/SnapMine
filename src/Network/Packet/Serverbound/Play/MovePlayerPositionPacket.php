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
        $session->getPlayer()->move(new Position($this->x, $this->feetY, $this->z));
    }
}