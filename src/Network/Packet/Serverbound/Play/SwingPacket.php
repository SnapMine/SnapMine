<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AnimatePacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SwingPacket extends ServerboundPacket {

    private int $hand = 0;

    public function getId(): int {
        return 0x3B;
    }

    public function read(PacketSerializer $serializer): void {
        $this->hand = $serializer->getVarInt();
    }

    public function handle(Session $session): void
    {
        $packet = new AnimatePacket($session->getPlayer(), $this->hand === 0 ? 0 : 3);
        $server = $session->getServer();

        foreach ($server->getPlayers() as $player) {
            if ($player->getUuid()->toString() === $session->uuid->toString()) {
                continue;
            }

            $player->sendPacket($packet);
        }
    }
}