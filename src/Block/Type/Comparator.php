<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\ComparatorMode;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

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