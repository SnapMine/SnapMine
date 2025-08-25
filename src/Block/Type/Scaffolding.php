<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Distance;
use SnapMine\Block\Data\Waterlogged;

class Scaffolding extends BlockData
{
    private bool $bottom = false;

    use Distance, Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['bottom' => $this->bottom]);
    }

    /**
     * @return bool
     */
    public function isBottom(): bool
    {
        return $this->bottom;
    }

    /**
     * @param bool $bottom
     */
    public function setBottom(bool $bottom): void
    {
        $this->bottom = $bottom;
    }
}