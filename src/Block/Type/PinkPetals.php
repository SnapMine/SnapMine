<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class PinkPetals extends BlockData
{
    private int $flowersAmount = 1;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['flower_amount' => $this->flowersAmount]);
    }

    /**
     * @return int
     */
    public function getFlowersAmount(): int
    {
        return $this->flowersAmount;
    }

    /**
     * @param int $flowersAmount
     */
    public function setFlowersAmount(int $flowersAmount): void
    {
        $this->flowersAmount = $flowersAmount;
    }

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::EAST,
            Direction::WEST,
            Direction::SOUTH,
        ];
    }
}