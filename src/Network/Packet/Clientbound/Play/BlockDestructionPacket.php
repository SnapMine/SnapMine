<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Entity\Entity;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\World\Position;

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