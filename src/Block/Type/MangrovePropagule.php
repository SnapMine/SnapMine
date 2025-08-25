<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Age;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Hanging;
use Nirbose\PhpMcServ\Block\Data\Stage;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class MangrovePropagule extends BlockData
{
    use Age, Hanging, Stage, Waterlogged;

    public function getMaximumAge(): int
    {
        return 4;
    }
}