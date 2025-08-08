<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class MoveEntityPosPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int  $entityId,
        private readonly int  $deltaX,
        private readonly int  $deltaY,
        private readonly int  $deltaZ,
        private readonly bool $onGround,
    )
    {
    }

    public function getId(): int
    {
        return 0x2E;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entityId)
            ->putShort($this->deltaX)
            ->putShort($this->deltaY)
            ->putShort($this->deltaZ)
            ->putBool($this->onGround);
    }
}