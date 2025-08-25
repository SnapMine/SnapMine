<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\FaceAttachable;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class PowerSwitch extends BlockData
{
    use FaceAttachable, Facing, Powerable;

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::EAST,
            Direction::SOUTH,
            Direction::WEST,
        ];
    }
}