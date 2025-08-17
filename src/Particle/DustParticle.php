<?php

namespace Nirbose\PhpMcServ\Particle;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\Serializer\ProtocolEncodable;
use Nirbose\PhpMcServ\Utils\Color;

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

    public function toPacket(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->color->getColor())
            ->putFloat($this->size);
    }
}