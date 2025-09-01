<?php

namespace SnapMine\Particle;

use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;
use SnapMine\Utils\Color;

class DustParticle implements ProtocolEncodable
{
    public function __construct(
        private Color $color,
        private float $size,
    )
    {
    }

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @return float
     */
    public function getSize(): float
    {
        return $this->size;
    }

    public function encode(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->color->getColor())
            ->putFloat($this->size);
    }
}