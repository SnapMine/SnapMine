<?php

namespace SnapMine\World;

class Location extends WorldPosition
{
    private float $yaw;
    private float $pitch;

    public function __construct(World $world, float $x, float $y, float $z, float $yaw = 0.0, float $pitch = 0.0)
    {
        parent::__construct($world, $x, $y, $z);

        $this->yaw = $yaw;
        $this->pitch = $pitch;
    }

    public function getYaw(): float
    {
        return $this->yaw;
    }

    public function getPitch(): float
    {
        return $this->pitch;
    }

    public function setYaw(float $yaw): void
    {
        $this->yaw = $yaw;
    }

    public function setPitch(float $pitch): void
    {
        $this->pitch = $pitch;
    }

    public static function fromPosition(World $world, Position $position): self
    {
        return new self($world, $position->getX(), $position->getY(), $position->getZ());
    }

    public static function fromWorldPosition(WorldPosition $position, float $yaw = 0.0, float $pitch = 0.0): self
    {
        return new self($position->getWorld(), $position->getX(), $position->getY(), $position->getZ(), $yaw, $pitch);
    }
}