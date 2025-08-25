<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Type;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class Chest extends BlockData
{
    use Facing, Waterlogged, Type;

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }


}