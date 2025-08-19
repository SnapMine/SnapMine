<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\Orientation;

trait Orientable
{
    protected Orientation $orientation = Orientation::DOWN_EAST;

    /**
     * @param Orientation $orientation
     */
    public function setOrientation(Orientation $orientation): void
    {
        $this->orientation = $orientation;
    }

    /**
     * @return Orientation
     */
    public function getOrientation(): Orientation
    {
        return $this->orientation;
    }
}