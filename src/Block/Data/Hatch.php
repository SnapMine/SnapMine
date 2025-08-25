<?php

namespace SnapMine\Block\Data;

trait Hatch
{
    protected int $hatch = 0;

    /**
     * @return int
     */
    public function getHatch(): int
    {
        return $this->hatch;
    }

    /**
     * @param int $hatch
     */
    public function setHatch(int $hatch): void
    {
        $this->hatch = $hatch;
    }
}