<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Type;
use SnapMine\Block\Direction;

class MovingPiston extends BlockData
{
    use Facing, Type;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}