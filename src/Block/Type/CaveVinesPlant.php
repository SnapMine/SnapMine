<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;

class CaveVinesPlant extends BlockData
{
    protected bool $berries = false;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['berries' => $this->berries]);
    }

    /**
     * @param bool $berries
     */
    public function setBerries(bool $berries): void
    {
        $this->berries = $berries;
    }

    /**
     * @return bool
     */
    public function hasBerries(): bool
    {
        return $this->berries;
    }
}