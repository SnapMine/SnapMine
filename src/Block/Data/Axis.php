<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\AxisType;

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