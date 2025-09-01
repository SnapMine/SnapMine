<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Effect\MobEffectType;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class RemoveMobEffectPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $entityId,
        private readonly MobEffectType $type,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putVarInt($this->entityId)
            ->putVarInt($this->type->value);
    }

    public function getId(): int
    {
        return 0x47;
    }
}