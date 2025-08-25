<?php

namespace SnapMine\Block\Data;

trait Openable
{
    protected bool $open = false;

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): void
    {
        $this->open = $open;
    }
}