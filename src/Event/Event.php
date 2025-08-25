<?php

namespace SnapMine\Event;

class Event implements Cancellable
{
    private bool $cancelled = false;

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancel): void
    {
        $this->cancelled = $cancel;
    }
}