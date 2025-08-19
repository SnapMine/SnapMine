<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Age;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Half;

class PitcherCrop extends BlockData
{
    use Age, Half;

    public function getMaximumAge(): int
    {
        return 4;
    }
}