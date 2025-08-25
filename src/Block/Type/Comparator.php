<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\ComparatorMode;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Comparator extends BlockData
{
    private ComparatorMode $mode = ComparatorMode::COMPARE;

    use Facing, Powerable;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['mode' => $this->mode]);
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

    /**
     * @return ComparatorMode
     */
    public function getMode(): ComparatorMode
    {
        return $this->mode;
    }

    /**
     * @param ComparatorMode $mode
     */
    public function setMode(ComparatorMode $mode): void
    {
        $this->mode = $mode;
    }
}