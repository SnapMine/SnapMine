<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Component\TextComponent;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Sheep;
use Nirbose\PhpMcServ\Event\EventManager;
use Nirbose\PhpMcServ\Event\Player\PlayerJoinEvent;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AddEntityPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Location;

class PlayerLoadedPacket extends ServerboundPacket {
    public function getId() : int {
        return 0x2A;
    }

    public function write(PacketSerializer $serializer): void {
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
    }
}