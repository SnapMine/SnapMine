<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Login;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Packet\Clientbound\Login\LoginSuccessPacket;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class LoginStartPacket extends Packet
{
    private string $username;
    private UUID $uuid;

    public function getId(): int
    {
        return 0x00;
    }

    public function write(PacketSerializer $serializer): void
    {
        // Not implemented
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->username = $serializer->getString($buffer, $offset);
        $this->uuid = UUID::generateOffline($this->username);
    }

    public function handle(Session $session): void
    {
        $session->username = $this->username;
        $session->uuid = $this->uuid;

        $session->sendPacket(new LoginSuccessPacket($this->username, $this->uuid));
    }
}