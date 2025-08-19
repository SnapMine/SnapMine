<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

class Observer extends BlockData
{
    use Facing, Powerable;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}