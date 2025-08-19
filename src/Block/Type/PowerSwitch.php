<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\FaceAttachable;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

class PowerSwitch extends BlockData
{
    use FaceAttachable, Facing, Powerable;

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::EAST,
            Direction::SOUTH,
            Direction::WEST,
        ];
    }
}