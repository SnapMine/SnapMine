<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;

class Farmland extends BlockData
{
    private int $moisture = 0;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['moisture' => $this->moisture]);
    }

    /**
     * @param int $moisture
     */
    public function setMoisture(int $moisture): void
    {
        $this->moisture = $moisture;
    }

    /**
     * @return int
     */
    public function getMoisture(): int
    {
        return $this->moisture;
    }
}