<?php

namespace SnapMine\Listener;

use SnapMine\Entity\Player;
use SnapMine\Event\EventBinding;
use SnapMine\Event\Listener;
use SnapMine\Event\Player\PlayerJoinEvent;
use SnapMine\Network\Packet\Clientbound\Play\AddEntityPacket;
use SnapMine\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;

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
        $playerInfoPacket = new PlayerInfoUpdatePacket(0x01,
            [
                $newPlayer->getUuid()->toString() => [
                    [
                        'name' => $newPlayer->getName(),
                    ],
                ]
            ]
        );
        $addEntityPacket = new AddEntityPacket(
            $newPlayer,
            0,
            0,
            0,
            0,
        );

        server()->broadcastPacket($playerInfoPacket);
        server()->broadcastPacket($addEntityPacket);
    }
}