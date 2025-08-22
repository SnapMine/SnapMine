<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Hanging;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class Lantern extends BlockData
{
    use Hanging, Waterlogged;
}