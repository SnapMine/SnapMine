<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Openable;
use SnapMine\Block\Direction;

class Barrel extends BlockData
{
    use Facing, Openable;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}