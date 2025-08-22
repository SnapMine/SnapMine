<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;

class MediumAmethystBud extends BlockData
{
    use Facing, Waterlogged;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}