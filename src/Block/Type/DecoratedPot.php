<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class DecoratedPot extends BlockData
{
    private bool $cracked = false;

    use Facing, Waterlogged;

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    public function computedId(array $data = []): int
    {
        return parent::computedId(['cracked' => $this->cracked]);
    }

    /**
     * @return bool
     */
    public function isCracked(): bool
    {
        return $this->cracked;
    }

    /**
     * @param bool $cracked
     */
    public function setCracked(bool $cracked): void
    {
        $this->cracked = $cracked;
    }
}