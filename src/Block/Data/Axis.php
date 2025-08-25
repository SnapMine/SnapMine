<?php

namespace SnapMine\Block\Data;

use SnapMine\Block\AxisType;

trait Axis
{
    protected AxisType $axis = AxisType::X;

    /**
     * @param AxisType $axis
     */
    public function setAxis(AxisType $axis): void
    {
        $this->axis = $axis;
    }

    /**
     * @return AxisType
     */
    public function getAxis(): AxisType
    {
        return $this->axis;
    }
}