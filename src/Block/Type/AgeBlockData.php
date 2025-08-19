<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Age;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

class AgeBlockData extends BlockData
{
    use Age;

    public function getMaximumAge(): int
    {
        return 25;
    }
}