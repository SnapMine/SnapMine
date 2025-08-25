<?php

namespace SnapMine\Network\Packet\Serverbound\Status;

use SnapMine\Network\Packet\Clientbound\Status\StatusResponsePacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Protocol;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class StatusRequestPacket extends ServerboundPacket
{
    public function getId(): int
    {
        return 0x00;
    }

    public function read(PacketSerializer $serializer): void
    {
    }

    public function handle(Session $session): void
    {
        $session->sendPacket(new StatusResponsePacket(json_encode([
            "version" => [
                "name" => Protocol::PROTOCOL_NAME,
                "protocol" => Protocol::PROTOCOL_VERSION,
            ],
            "players" => [
                "max" => $session->getServer()->getMaxPlayer(),
                "online" => count($session->getServer()->getPlayers()),
                "sample" => [],
            ],
            "description" => [
                "text" => $session->getServer()->getConfig()->get('motd'),
            ],
        ])));
    }
}