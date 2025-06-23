<?php

namespace Nirbose\PhpMcServ\World;

class Location extends Position {
    private float $yaw;
    private float $pitch;

    public function __construct(float $x, float $y, float $z, float $yaw = 0.0, float $pitch = 0.0) {
        parent::__construct($x, $y, $z);
        $this->yaw = $yaw;
        $this->pitch = $pitch;
    }

    public function getYaw(): float {
        return $this->yaw;
    }

    public function getPitch(): float {
        return $this->pitch;
    }

    public function setYaw(float $yaw): void {
        $this->yaw = $yaw;
    }

    public function setPitch(float $pitch): void {
        $this->pitch = $pitch;
    }
}