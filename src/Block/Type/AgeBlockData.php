<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\BlockStateLoader;
use SnapMine\Block\Data\Age;
use SnapMine\Block\Data\BlockData;
use SnapMine\Material;

class AgeBlockData extends BlockData
{
    use Age;

    public function getMaximumAge(): int
    {
        return 25;
    }
}