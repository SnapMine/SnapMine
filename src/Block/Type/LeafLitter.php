<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class LeafLitter extends BlockData
{
    private int $segmentAmount = 1;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['segment_amount' => $this->segmentAmount]);
    }

    /**
     * @param int $segmentAmount
     */
    public function setSegmentAmount(int $segmentAmount): void
    {
        $this->segmentAmount = $segmentAmount;
    }

    /**
     * @return int
     */
    public function getSegmentAmount(): int
    {
        return $this->segmentAmount;
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