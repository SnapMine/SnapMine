<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\MultipleFacing;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class GlassPane extends BlockData
{
    use MultipleFacing, Waterlogged;

    /**
     * @inheritDoc
     */
    public function getAllowedFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }
}