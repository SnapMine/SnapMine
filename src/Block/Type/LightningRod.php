<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class LightningRod extends BlockData
{
    use Facing, Powerable, Waterlogged;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}