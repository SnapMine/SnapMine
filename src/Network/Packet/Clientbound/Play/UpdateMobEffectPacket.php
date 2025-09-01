<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Effect\MobEffect;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class UpdateMobEffectPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $entityId,
        private readonly MobEffect $mobEffect,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entityId);
        $this->mobEffect->toPacket($serializer);
    }

    public function getId(): int
    {
        return 0x7D;
    }
}