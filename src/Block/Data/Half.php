<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\HalfType;

trait Half
{
    protected HalfType $half = HalfType::BOTTOM;

    /**
     * @return HalfType
     */
    public function getHalf(): HalfType
    {
        return $this->half;
    }

    /**
     * @param HalfType $half
     */
    public function setHalf(HalfType $half): void
    {
        $this->half = $half;
    }
}