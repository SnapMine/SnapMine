<?php

namespace Nirbose\PhpMcServ\Particle;

use Nirbose\PhpMcServ\Utils\Color;

class DustColorTransitionParticle
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
}