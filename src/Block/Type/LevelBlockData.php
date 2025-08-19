<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Level;

class LevelBlockData extends BlockData
{
    use Level;

    public function getMaximumLevel(): int
    {
        return 15;
    }
}