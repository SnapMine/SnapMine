<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;

class Fence extends BlockData
{
    use MultipleFacing, Waterlogged;

    public function getAllowedFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::EAST,
            Direction::SOUTH,
            Direction::WEST,
        ];
    }
}