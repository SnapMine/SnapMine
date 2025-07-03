<?php

namespace Nirbose\PhpMcServ\Listener;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Event\EventBinding;
use Nirbose\PhpMcServ\Event\Listener;
use Nirbose\PhpMcServ\Event\Player\PlayerJoinEvent;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AddEntityPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\UUID;

class PlayerJoinListener implements Listener
{

    #[EventBinding]
    public function onPlayerJoin(PlayerJoinEvent $event): void
    {
        $newPlayer = $event->getPlayer();
        $this->broadcastNewPlayer($newPlayer);

        $infos = [];

        /** @var Player $player */
        foreach (Artisan::getPlayers() as $player) {
            if ($newPlayer->getUuid() === $player->getUuid()) {
                continue;
            }

            $infos[$player->getUuid()->toString()] = [
                [
                    'name' => $player->getName(),
                ]
            ];
        }

        $newPlayer->sendPacket(new PlayerInfoUpdatePacket(0x01, $infos));

        foreach ($infos as $uuid => $playerInfo) {
            $packet = new AddEntityPacket(
                random_int(6, 1000),
                UUID::fromString($uuid),
                EntityType::PLAYER,
                0,
                64,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0
            );

            $player->sendPacket(
                $packet
            );
        }
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
                random_int(6, 1000),
                $uuid,
                EntityType::PLAYER,
                0,
                64,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0
            );

            $player->sendPacket(
                $packet
            );
        }
    }
}