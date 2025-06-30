<?php

namespace Nirbose\PhpMcServ\Listener;

use Nirbose\PhpMcServ\Event\EventBinding;
use Nirbose\PhpMcServ\Event\Listener;
use Nirbose\PhpMcServ\Event\PlayerJoinEvent;

class PlayerJoinListener implements Listener
{

    #[EventBinding]
    public function onPlayerJoin(PlayerJoinEvent $event): void
    {
        var_dump($event->getPlayer()->getName());
    }
}