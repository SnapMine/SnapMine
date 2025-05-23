<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Status;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Packet\Clientbound\Status\StatusResponsePacket;
use Nirbose\PhpMcServ\Session\Session;

class StatusRequestPacket extends Packet
{
    public function getId(): int
    {
        return 0x00;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        // No data to read for StatusRequestPacket
    }

    public function write(PacketSerializer $serializer): void
    {
        // No data to write for StatusRequestPacket
    }

    public function handle(Session $session): void
    {
        // Handle the status request by sending a response
        $session->sendPacket(new StatusResponsePacket(json_encode([
            "version" => [
                "name" => \Nirbose\PhpMcServ\Network\Protocol::PROTOCOL_NAME,
                "protocol" => \Nirbose\PhpMcServ\Network\Protocol::PROTOCOL_VERSION,
            ],
            "players" => [
                "max" => 20,
                "online" => 0,
                "sample" => [],
            ],
            "description" => [
                "text" => "Welcome to the server!",
            ],
        ])));
    }
}