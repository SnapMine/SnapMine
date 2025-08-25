<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Age;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Half;

class PitcherCrop extends BlockData
{
    use Age, Half;

    public function getMaximumAge(): int
    {
        return 4;
    }
}