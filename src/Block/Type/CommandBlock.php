<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Direction;

class CommandBlock extends BlockData
{
    private bool $conditional = false;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['conditional' => $this->conditional]);
    }

    public function getFaces(): array
    {
        return Direction::cases();
    }
}