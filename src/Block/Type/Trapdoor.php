<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Half;
use SnapMine\Block\Data\Openable;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class Trapdoor extends BlockData
{
    use Facing, Half, Openable, Powerable, Waterlogged;

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