<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Entity\Entity;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

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