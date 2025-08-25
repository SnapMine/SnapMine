<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Level;
use SnapMine\Block\Data\Waterlogged;

class Light extends BlockData
{
    use Level, Waterlogged;

    public function getMaximumLevel(): int
    {
        return 15;
    }
}