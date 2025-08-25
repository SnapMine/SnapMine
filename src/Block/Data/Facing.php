<?php

namespace SnapMine\Block\Data;

use Exception;
use SnapMine\Block\Direction;

trait Facing
{
    protected Direction $facing = Direction::EAST;

    /**
     * @return Direction[]
     */
    abstract public function getFaces(): array;

    public function getFacing(): Direction
    {
        return $this->facing;
    }

    /**
     * @throws Exception
     */
    public function setFacing(Direction $direction): void
    {
        if (in_array($direction, $this->getFaces())) {
            $this->facing = $direction;
            return;
        }

        throw new Exception("Direction $direction->name is not allowed.");
    }
}