<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Entity\Entity;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class SetEntityDataPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Entity $entity,
    ) {
    }

    public function getId(): int
    {
        return 0x5C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entity->getId());

        $serializer->put($this->entity->serialize());
    }


}