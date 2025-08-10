<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Exception;
use Nirbose\PhpMcServ\Block\Direction;

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