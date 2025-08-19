<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Drag
{
    protected bool $drag;

    /**
     * @param bool $drag
     */
    public function setDrag(bool $drag): void
    {
        $this->drag = $drag;
    }

    /**
     * @return bool
     */
    public function isDrag(): bool
    {
        return $this->drag;
    }
}