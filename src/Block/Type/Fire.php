<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Age;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\MultipleFacing;
use SnapMine\Block\Direction;

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