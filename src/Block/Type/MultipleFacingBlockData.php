<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Direction;

class MultipleFacingBlockData extends BlockData
{
    use MultipleFacing;

    public function getAllowedFaces(): array
    {
        return Direction::cases();
    }
}