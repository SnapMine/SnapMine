<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Attached
{
    protected bool $attached = false;

    public function setAttached(bool $attached): void
    {
        $this->attached = $attached;
    }

    public function isAttached(): bool
    {
        return $this->attached;
    }
}