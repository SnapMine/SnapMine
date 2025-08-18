<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class AddEntityPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Entity $entity,
        private readonly int $data,
        private readonly int $velocityX,
        private readonly int $velocityY,
        private readonly int $velocityZ,
    )
    {
    }

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $loc = $this->entity->getLocation();

        $serializer->putVarInt($this->entity->getId())
            ->putUUID($this->entity->getUUID())
            ->putVarInt($this->entity->getType()->value)
            ->putDouble($loc->getX())
            ->putDouble($loc->getY())
            ->putDouble($loc->getZ())
            ->putByte((int)round($loc->getPitch() * 256 / 360))
            ->putByte((int)round($loc->getYaw() * 256 / 360))
            ->putByte((int)round($loc->getYaw() * 256 / 360))
            ->putVarInt($this->data)
            ->putShort($this->velocityX)
            ->putShort($this->velocityY)
            ->putShort($this->velocityZ);
    }
}