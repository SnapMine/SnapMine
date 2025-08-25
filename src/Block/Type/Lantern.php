<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Hanging;
use SnapMine\Block\Data\Waterlogged;

class Lantern extends BlockData
{
    use Hanging, Waterlogged;
}