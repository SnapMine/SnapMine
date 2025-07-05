<?php

namespace Nirbose\PhpMcServ\Event\Player;

use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Event\Event;

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