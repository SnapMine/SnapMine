<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Age;

class CaveVines extends CaveVinesPlant
{
    use Age;

    public function getMaximumAge(): int
    {
        return 25;
    }
}