<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SynchronizePlayerPositionPacket extends ClientboundPacket
{
    const RELATIVE_X = 0x0001;
    const RELATIVE_Y = 0x0002;
    const RELATIVE_Z = 0x0004;
    const RELATIVE_YAW = 0x0008;
    const RELATIVE_PITCH = 0x0010;
    const RELATIVE_VELOCITY_X = 0x0020;
    const RELATIVE_VELOCITY_Y = 0x0040;
    const RELATIVE_VELOCITY_Z = 0x0080;
    const ROTATE_VELOCITY = 0x0100;

    public function __construct(
        private Player $player,
        private float  $velocityX,
        private float  $velocityY,
        private float  $velocityZ,
        private int    $flags = 0
    )
    {
    }

    public function getId(): int
    {
        return 0x41;
    }

    public function write(PacketSerializer $serializer): void
    {
        $loc = $this->player->getLocation();

        $serializer->putVarInt($this->player->getId())
            ->putDouble($loc->getX()) // x
            ->putDouble($loc->getY()) // y
            ->putDouble($loc->getZ()) // z
            ->putDouble($this->velocityX) // velocityX
            ->putDouble($this->velocityY) // velocityY
            ->putDouble($this->velocityZ) // velocityZ
            ->putFloat($loc->getYaw()) // yaw
            ->putFloat($loc->getPitch()) // pitch
            ->putInt($this->flags); // flags
    }

}