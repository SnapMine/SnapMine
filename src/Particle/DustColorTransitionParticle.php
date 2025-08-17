<?php

namespace Nirbose\PhpMcServ\Particle;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\Serializer\ProtocolEncodable;
use Nirbose\PhpMcServ\Utils\Color;

class DustColorTransitionParticle implements ProtocolEncodable
{
    public function __construct(
        private Color $from,
        private Color $to,
        private float $scale,
    )
    {
    }

    /**
     * @return Color
     */
    public function getFrom(): Color
    {
        return $this->from;
    }

    /**
     * @return Color
     */
    public function getTo(): Color
    {
        return $this->to;
    }

    /**
     * @return float
     */
    public function getScale(): float
    {
        return $this->scale;
    }

    public function toPacket(PacketSerializer $serializer): void
    {
        $serializer
            ->putInt($this->from->getColor())
            ->putInt($this->to->getColor())
            ->putFloat($this->scale);
    }
}