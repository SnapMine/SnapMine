<?php

namespace SnapMine\World;

class WorldPosition extends Position
{
    private World $world;

    public function __construct(World $world, float $x, float $y, float $z)
    {
        parent::__construct($x, $y, $z);

        $this->world = $world;
    }

    /**
     * @return World
     */
    public function getWorld(): World
    {
        return $this->world;
    }

    /**
     * @param World $world
     */
    public function setWorld(World $world): void
    {
        $this->world = $world;
    }
    
    public static function fromPosition(World $world, Position $position): self
    {
        return new self($world, $position->getX(), $position->getY(), $position->getZ());
    }
}