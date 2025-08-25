<?php

namespace SnapMine\Event\Player;

use SnapMine\Entity\Player;
use SnapMine\Event\Event;

class PlayerJoinEvent extends Event
{
    public function __construct(
        private readonly Player $player
    )
    {
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }
}