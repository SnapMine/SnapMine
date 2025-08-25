<?php

namespace SnapMine\Block\Data;

trait Stage
{
    protected int $stage = 0;

    /**
     * @param int $stage
     */
    public function setStage(int $stage): void
    {
        $this->stage = $stage;
    }

    /**
     * @return int
     */
    public function getStage(): int
    {
        return $this->stage;
    }
}