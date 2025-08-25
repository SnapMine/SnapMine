<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Clientbound\Play\AnimatePacket;
use SnapMine\Network\Packet\Packet;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

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