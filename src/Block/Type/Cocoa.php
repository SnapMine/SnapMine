<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Age;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class Cocoa extends BlockData
{
    use Age, Facing;

    public function getMaximumAge(): int
    {
        return 2;
    }

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