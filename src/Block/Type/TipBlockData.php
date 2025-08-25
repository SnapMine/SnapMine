<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;

class TipBlockData extends BlockData
{
    private bool $tip = false;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['tip' => $this->tip]);
    }

    /**
     * @param bool $tip
     */
    public function setTip(bool $tip): void
    {
        $this->tip = $tip;
    }

    /**
     * @return bool
     */
    public function isTip(): bool
    {
        return $this->tip;
    }
}