<?php

namespace Nirbose\PhpMcServ\Particle;

use _PHPStan_f9a2208af\Symfony\Component\Console\Color;

class TrailParticle
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
}