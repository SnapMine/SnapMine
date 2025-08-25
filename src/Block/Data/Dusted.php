<?php

namespace SnapMine\Block\Data;

trait Dusted
{
    protected int $progress = 0;

    /**
     * @param int $progress
     */
    public function setDustingProgress(int $progress): void
    {
        $this->progress = $progress;
    }

    /**
     * @return int
     */
    public function getDustingProgress(): int
    {
        return $this->progress;
    }
}