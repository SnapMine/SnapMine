<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;
use SnapMine\Particle\Particle;

class LevelParticles extends ClientboundPacket
{
    public function __construct(
        private readonly Particle                         $particle,
        private readonly int                              $number,
        private readonly float                            $x,
        private readonly float                            $y,
        private readonly float                            $z,
        private readonly float                            $offsetX,
        private readonly float                            $offsetY,
        private readonly float                            $offsetZ,
        private readonly float                            $maxSpeed,
        private readonly bool                             $longDistance,
        private readonly bool                             $alwaysVisible,
        private readonly ProtocolEncodable|float|int|null $data = null,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putBool($this->longDistance)
            ->putBool($this->alwaysVisible)
            ->putDouble($this->x)
            ->putDouble($this->y)
            ->putDouble($this->z)
            ->putFloat($this->offsetX)
            ->putFloat($this->offsetY)
            ->putFloat($this->offsetZ)
            ->putFloat($this->maxSpeed)
            ->putInt($this->number)
            ->putVarInt($this->particle->value);

        if ($this->data !== null) {
            $dataClass = $this->particle->getDataClass();

            if ($dataClass == 'varint') {
                $serializer->putVarInt($this->data);
            } else if ($dataClass == 'float') {
                $serializer->putFloat($this->data);
            } else {
                $serializer->putObject($this->data);
            }
        }
    }

    public function getId(): int
    {
        return 0x29;
    }
}