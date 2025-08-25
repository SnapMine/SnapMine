<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Direction;

class Barrel extends BlockData
{
    use Facing, Openable;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}