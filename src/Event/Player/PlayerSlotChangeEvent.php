<?php

namespace Nirbose\PhpMcServ\Event\Player;

use Nirbose\PhpMcServ\Event\Event;

class PlayerSlotChangeEvent extends Event
{
    public function __construct(
        private readonly int $slot
    )
    {
    }

    public function getSlot(): int
    {
        return $this->slot;
    }
}