<?php

namespace SnapMine\Block\Data;

trait Power
{
    protected int $power = 0;

    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @param int $power
     */
    public function setPower(int $power): void
    {
        $this->power = $power;
    }
}