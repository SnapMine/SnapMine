<?php

namespace SnapMine\Event\Player;

use SnapMine\Event\Event;

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