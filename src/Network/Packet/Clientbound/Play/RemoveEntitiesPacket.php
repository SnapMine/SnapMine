<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Entity\Entity;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class RemoveEntitiesPacket extends ClientboundPacket
{
    /**
     * @param array<int|Entity> $entities
     */
    public function __construct(
        private readonly array $entities,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt(count($this->entities));

        foreach ($this->entities as $entity) {
            $serializer->putVarInt($entity instanceof Entity ? $entity->getId() : $entity);
        }
    }

    public function getId(): int
    {
        return 0x46;
    }
}