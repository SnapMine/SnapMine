<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;

class SculkVein extends BlockData
{
    use MultipleFacing, Waterlogged;

    public function getAllowedFaces(): array
    {
        return Direction::cases();
    }
}