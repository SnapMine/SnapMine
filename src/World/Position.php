<?php

namespace SnapMine\World;

use SnapMine\Block\Direction;

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

    public function addDirection(Direction $direction): self
    {
        [$x, $y, $z] = $direction->getVec3();

        $newPos = clone $this;

        $newPos->x += $x;
        $newPos->y += $y;
        $newPos->z += $z;

        return $newPos;
    }

    public function add(Position $position): self
    {
        $newPos = clone $this;

        $newPos->setY($this->getY() + $position->getY());
        $newPos->setX($this->getX() + $position->getX());
        $newPos->setZ($this->getZ() + $position->getZ());

        return $newPos;
    }
}