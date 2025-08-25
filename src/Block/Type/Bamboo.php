<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Age;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Stage;
use SnapMine\Block\LeavesType;

class Bamboo extends BlockData
{
    private LeavesType $leaves = LeavesType::LARGE;

    use Age, Stage;

    public function getMaximumAge(): int
    {
        return 1;
    }

    public function computedId(array $data = []): int
    {
        return parent::computedId(['leaves' => $this->leaves]);
    }

    /**
     * @param LeavesType $leaves
     */
    public function setLeaves(LeavesType $leaves): void
    {
        $this->leaves = $leaves;
    }

    /**
     * @return LeavesType
     */
    public function getLeaves(): LeavesType
    {
        return $this->leaves;
    }
}