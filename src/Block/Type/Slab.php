<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Type;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class Slab extends BlockData
{
    use Waterlogged, Type;
}