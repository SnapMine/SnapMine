<?php

namespace Nirbose\PhpMcServ\Listener;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Event\EventBinding;
use Nirbose\PhpMcServ\Event\Listener;
use Nirbose\PhpMcServ\Event\Player\PlayerJoinEvent;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AddEntityPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;

class PlayerJoinListener implements Listener
{

    #[EventBinding]
    public function onPlayerJoin(PlayerJoinEvent $event): void
    {
        $newPlayer = $event->getPlayer();
        $this->broadcastNewPlayer($newPlayer);
    }

    private function broadcastNewPlayer(Player $newPlayer): void
    {
        /** @var Player $player */
        foreach (Artisan::getPlayers() as $player) {
            $uuid = $newPlayer->getUuid();

            $player->sendPacket(new PlayerInfoUpdatePacket(0x01,
                [
                    $uuid->toString() => [
                        [
                            'name' => $newPlayer->getName(),
                        ],
                    ]
                ]
            ));

            $packet = new AddEntityPacket(
                $newPlayer,
                0,
                0,
                0,
                0,
                0,
            );

            $player->sendPacket(
                $packet
            );
        }
    }
}