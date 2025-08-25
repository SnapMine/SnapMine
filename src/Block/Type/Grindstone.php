<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\FaceAttachable;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class Grindstone extends BlockData
{
    use FaceAttachable, Facing;

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