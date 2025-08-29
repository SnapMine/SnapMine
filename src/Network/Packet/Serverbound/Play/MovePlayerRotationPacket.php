<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityRotPacket;
use SnapMine\Network\Packet\Clientbound\Play\RotateHeadPacket;
use SnapMine\Network\Packet\Packet;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;

class MovePlayerRotationPacket extends ServerboundPacket {
    private float $yaw;
    private float $pitch;

    public function getId(): int
    {
        return 0x1E;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->yaw = $serializer->getFloat();
        $this->pitch = $serializer->getFloat();
    }

    public function handle(Session $session): void
    {
        $session->getPlayer()->move($session->getPlayer()->getLocation(), $this->yaw, $this->pitch);
    }
}