<?php

namespace Nirbose\PhpMcServ\Event;

interface Cancellable
{
    public function isCancelled(): bool;

    public function setCancelled(bool $cancel): void;
}