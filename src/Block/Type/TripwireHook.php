<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Attached;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class TripwireHook extends BlockData
{
    use Attached, Facing, Powerable;

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