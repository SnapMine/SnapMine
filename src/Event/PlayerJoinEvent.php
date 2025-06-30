<?php

namespace Nirbose\PhpMcServ\Event;

use Nirbose\PhpMcServ\Entity\Player;

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