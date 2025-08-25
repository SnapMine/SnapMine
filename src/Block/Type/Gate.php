<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Openable;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

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