<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class MoveEntityRotPacket extends ClientboundPacket
{

    public function __construct(
        private readonly Entity $entity,
        private readonly bool   $onGround,
    )
    {
    }

    public function getId(): int
    {
        return 0x31;
    }

    public function write(PacketSerializer $serializer): void
    {
        $loc = $this->entity->getLocation();

        $serializer->putVarInt($this->entity->getId())
            ->putAngle($loc->getYaw())
            ->putAngle($loc->getPitch())
            ->putBool($this->onGround);
    }
}