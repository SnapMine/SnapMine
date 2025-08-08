<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Status;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Status\StatusResponsePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Protocol;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

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
                "text" => "Welcome to the server!",
            ],
        ])));
    }
}