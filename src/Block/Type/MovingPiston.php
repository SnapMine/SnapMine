<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Type;
use Nirbose\PhpMcServ\Block\Direction;

class MovingPiston extends BlockData
{
    use Facing, Type;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}