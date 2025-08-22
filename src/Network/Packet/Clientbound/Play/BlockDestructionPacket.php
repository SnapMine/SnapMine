<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\World\Position;

class BlockDestructionPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Entity $entity,
        private readonly Position $position,
        private readonly int $destroyStage,
    )
    {

    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putVarInt($this->entity->getId())
            ->putPosition($this->position)
            ->putUnsignedByte($this->destroyStage);
    }

    public function getId(): int
    {
        return 0x05;
    }
}