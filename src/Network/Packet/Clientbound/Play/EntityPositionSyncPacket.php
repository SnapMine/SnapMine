<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class EntityPositionSyncPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $entityId,
        private readonly float $x,
        private readonly float $y,
        private readonly float $z,
        private readonly float $velocityX,
        private readonly float $velocityY,
        private readonly float $velocityZ,
        private readonly float $yaw,
        private readonly float $pitch,
        private readonly bool $onGround
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putVarInt($this->entityId)
            ->putDouble($this->x)
            ->putDouble($this->y)
            ->putDouble($this->z)
            ->putDouble($this->velocityX)
            ->putDouble($this->velocityY)
            ->putDouble($this->velocityZ)
            ->putFloat($this->yaw)
            ->putFloat($this->pitch)
            ->putBool($this->onGround);
    }

    public function getId(): int
    {
        return 0x1F;
    }
}