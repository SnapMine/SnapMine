<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Observer extends BlockData
{
    use Facing, Powerable;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}