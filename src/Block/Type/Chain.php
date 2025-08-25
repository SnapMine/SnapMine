<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Axis;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Waterlogged;

class Chain extends BlockData
{
    use Axis, Waterlogged;
}