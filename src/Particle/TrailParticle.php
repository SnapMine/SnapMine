<?php

namespace SnapMine\Particle;

use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;
use SnapMine\Utils\Color;

class TrailParticle implements ProtocolEncodable
{
    public function __construct(
        private float $x,
        private float $y,
        private float $z,
        private Color $color,
        private int $duration,
    )
    {
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @return float
     */
    public function getZ(): float
    {
        return $this->z;
    }

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    public function toPacket(PacketSerializer $serializer): void
    {
        $serializer
            ->putDouble($this->x)
            ->putDouble($this->y)
            ->putDouble($this->z)
            ->putInt($this->color->getColor())
            ->putVarInt($this->duration);
    }
}