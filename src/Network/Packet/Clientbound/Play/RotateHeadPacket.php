<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class RotateHeadPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Entity $entity,
    ) {
    }

    public function getId(): int
    {
        return 0x4C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entity->getId())
            ->putAngle($this->entity->getLocation()->getYaw());
    }
}