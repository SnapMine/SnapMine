<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;

class SnowyBlockData extends BlockData
{
    private bool $isSnowy = false;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['snowy' => $this->isSnowy]);
    }

    /**
     * @return bool
     */
    public function isSnowy(): bool
    {
        return $this->isSnowy;
    }

    /**
     * @param bool $isSnowy
     */
    public function setSnowy(bool $isSnowy): void
    {
        $this->isSnowy = $isSnowy;
    }
}