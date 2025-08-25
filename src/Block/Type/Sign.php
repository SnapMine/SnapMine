<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Rotatable;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class Sign extends BlockData
{
    use Rotatable, Waterlogged;

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