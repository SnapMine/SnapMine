<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Level;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class Light extends BlockData
{
    use Level, Waterlogged;

    public function getMaximumLevel(): int
    {
        return 15;
    }
}