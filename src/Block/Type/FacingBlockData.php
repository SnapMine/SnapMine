<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class FacingBlockData extends BlockData
{
    use Facing;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}