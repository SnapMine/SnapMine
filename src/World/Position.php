<?php

namespace Nirbose\PhpMcServ\World;

use Nirbose\PhpMcServ\Block\Direction;

class Position {
    private float $x;
    private float $y;
    private float $z;

    public function __construct(float $x, float $y, float $z) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function getX(): float {
        return $this->x;
    }

    public function getY(): float {
        return $this->y;
    }

    public function getZ(): float {
        return $this->z;
    }

    public function setX(float $x): void {
        $this->x = $x;
    }

    public function setY(float $y): void {
        $this->y = $y;
    }

    public function setZ(float $z): void {
        $this->z = $z;
    }

    public function add(Direction $direction): void
    {
        [$x, $y, $z] = $direction->getVec3();

        $this->x += $x;
        $this->y += $y;
        $this->z += $z;
    }
}