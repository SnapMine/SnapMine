<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Triggered;
use SnapMine\Block\Direction;

class Dispenser extends BlockData
{
    use Facing, Triggered;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}