<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Sheep;
use Nirbose\PhpMcServ\Event\EventManager;
use Nirbose\PhpMcServ\Event\Player\PlayerJoinEvent;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AddEntityPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\RotateHeadPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetEntityDataPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Location;

class PlayerLoadedPacket extends Packet {
    public function getId() : int {
        return 0x2A;
    }

    public function write(\Nirbose\PhpMcServ\Network\Serializer\PacketSerializer $serializer): void {
    }

    public function read(\Nirbose\PhpMcServ\Network\Serializer\PacketSerializer $serializer, string $buffer, int &$offset): void {
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

        $this->test($session);
    }

    private function test(Session $session)
    {
        $sheep = $session->getServer()->spawnEntity(EntityType::SHEEP);
        $sheep->setOnFire(true);

        $sheep->update();
    }
}