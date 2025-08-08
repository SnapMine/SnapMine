<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class MoveEntityPosRotPacket extends ClientboundPacket
{

    public function __construct(
        private readonly int   $entityId,
        private readonly int   $deltaX,
        private readonly int   $deltaY,
        private readonly int   $deltaZ,
        private readonly float $yaw,
        private readonly float $pitch,
        private readonly bool  $onGround,
    )
    {
    }

    public function getId(): int
    {
        return 0x2F;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entityId)
            ->putShort($this->deltaX)
            ->putShort($this->deltaY)
            ->putShort($this->deltaZ)
            ->putAngle($this->yaw)
            ->putAngle($this->pitch)
            ->putBool($this->onGround);
    }

}