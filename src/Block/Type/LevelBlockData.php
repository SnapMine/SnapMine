<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Level;

class LevelBlockData extends BlockData
{
    use Level;

    public function getMaximumLevel(): int
    {
        return 15;
    }
}