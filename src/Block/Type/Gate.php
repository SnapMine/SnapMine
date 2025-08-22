<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

class Gate extends BlockData
{
    private bool $inWall = false;

    use Facing, Openable, Powerable;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['in_wall' => $this->inWall]);
    }

    /**
     * @param bool $inWall
     */
    public function setInWall(bool $inWall): void
    {
        $this->inWall = $inWall;
    }

    /**
     * @return bool
     */
    public function isInWall(): bool
    {
        return $this->inWall;
    }

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }
}