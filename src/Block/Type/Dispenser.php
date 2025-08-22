<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Triggered;
use Nirbose\PhpMcServ\Block\Direction;

class Dispenser extends BlockData
{
    use Facing, Triggered;

    public function getFaces(): array
    {
        return Direction::cases();
    }
}