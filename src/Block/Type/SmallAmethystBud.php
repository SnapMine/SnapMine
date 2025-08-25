<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class SmallAmethystBud extends BlockData
{
    use Facing, Waterlogged;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}