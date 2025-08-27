<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Artisan;
use SnapMine\Event\EventManager;
use SnapMine\Event\Player\PlayerJoinEvent;
use SnapMine\Network\Packet\Clientbound\Play\AddEntityPacket;
use SnapMine\Network\Packet\Clientbound\Play\CommandsPacket;
use SnapMine\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class PlayerLoadedPacket extends ServerboundPacket {
    public function getId() : int {
        return 0x2A;
    }

    public function read(PacketSerializer $serializer): void {
    }

    public function handle(Session $session): void
    {
        $newPlayer = $session->getPlayer();

        $event = EventManager::call(
            new PlayerJoinEvent($newPlayer)
        );

        if ($event->isCancelled()) {
            // TODO: Disconnect player
            return;
        }

        $session->getServer()->addPlayer($newPlayer);

        foreach (Artisan::getPlayers() as $player) {
            if ($newPlayer->getUuid()->toString() === $player->getUuid()->toString()) {
                continue;
            }

            $infos[$player->getUuid()->toString()] = [
                [
                    'name' => $player->getName(),
                ]
            ];
        }

        if (!empty($infos)) {
            $newPlayer->sendPacket(new PlayerInfoUpdatePacket(
                PlayerInfoUpdatePacket::ADD_PLAYER,
                $infos
            ));

            foreach (Artisan::getPlayers() as $player) {
                $packetAddEntity = new AddEntityPacket(
                    $player,
                    0,
                    0,
                    0,
                    0,
                );
                $newPlayer->sendPacket($packetAddEntity);
            }
        }

        $session->sendPacket(new CommandsPacket($session->getServer()->getCommandManager()->build(), 0));
    }
}