<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\MultipleFacing;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class GlowLichen extends BlockData
{
    use MultipleFacing, Waterlogged;

    public function getAllowedFaces(): array
    {
        return Direction::cases();
    }
}