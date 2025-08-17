<?php

namespace Nirbose\PhpMcServ\Particle;

use Nirbose\PhpMcServ\Utils\Color;

class DustParticle
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
}