<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Age;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Hanging;
use SnapMine\Block\Data\Stage;
use SnapMine\Block\Data\Waterlogged;

class MangrovePropagule extends BlockData
{
    use Age, Hanging, Stage, Waterlogged;

    public function getMaximumAge(): int
    {
        return 4;
    }
}