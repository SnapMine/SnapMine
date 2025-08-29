<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityPosRotPacket;
use SnapMine\Network\Packet\Clientbound\Play\RotateHeadPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;

class MovePlayerPositionRotationPacket extends ServerboundPacket
{

    private float $x;
    private float $feetY;
    private float $z;
    private float $yaw;
    private float $pitch;
    /** @phpstan-ignore property.onlyWritten */
    private bool $flags;

    public function getId(): int
    {
        return 0x1D;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->x = $serializer->getDouble();
        $this->feetY = $serializer->getDouble();
        $this->z = $serializer->getDouble();
        $this->yaw = $serializer->getFloat();
        $this->pitch = $serializer->getFloat();
        $this->flags = $serializer->getBool();
    }

    public function handle(Session $session): void
    {
        $session->getPlayer()->move(new Position($this->x, $this->feetY, $this->z), $this->yaw, $this->pitch);
    }
}