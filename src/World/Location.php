<?php

namespace SnapMine\World;

class Location extends Position {
    private World $world;
    private float $yaw;
    private float $pitch;

    public function __construct(World $world, float $x, float $y, float $z, float $yaw = 0.0, float $pitch = 0.0) {
        parent::__construct($x, $y, $z);

        $this->world = $world;
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

    /**
     * @return World
     */
    public function getWorld(): World
    {
        return $this->world;
    }
}