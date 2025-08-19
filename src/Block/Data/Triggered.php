<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Triggered
{
    protected bool $triggered = false;

    /**
     * @param bool $triggered
     */
    public function setTriggered(bool $triggered): void
    {
        $this->triggered = $triggered;
    }

    /**
     * @return bool
     */
    public function isTriggered(): bool
    {
        return $this->triggered;
    }
}