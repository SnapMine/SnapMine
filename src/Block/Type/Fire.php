<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Age;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Direction;

class Fire extends BlockData
{
    use Age, MultipleFacing;

    public function getAllowedFaces(): array
    {
        return [
            Direction::EAST,
            Direction::NORTH,
            Direction::SOUTH,
            Direction::UP,
            Direction::WEST,
        ];
    }

    public function getMaximumAge(): int
    {
        return 15;
    }
}