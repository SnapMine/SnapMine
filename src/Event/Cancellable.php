<?php

namespace SnapMine\Event;

interface Cancellable
{
    public function isCancelled(): bool;

    public function setCancelled(bool $cancel): void;
}