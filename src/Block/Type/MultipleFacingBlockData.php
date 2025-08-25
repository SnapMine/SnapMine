<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\MultipleFacing;
use SnapMine\Block\Direction;

class MultipleFacingBlockData extends BlockData
{
    use MultipleFacing;

    public function getAllowedFaces(): array
    {
        return Direction::cases();
    }
}