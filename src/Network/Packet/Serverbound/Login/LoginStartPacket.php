<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Login;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Login\LoginSuccessPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class LoginStartPacket extends ServerboundPacket
{
    private string $username;

    public function getId(): int
    {
        return 0x00;
    }

    /**
     * @throws \Exception
     */
    public function read(PacketSerializer $serializer): void
    {
        $this->username = $serializer->getString();
    }

    public function handle(Session $session): void
    {
        $session->username = $this->username;
        $session->uuid = UUID::generateOffline($this->username);

        $session->sendPacket(new LoginSuccessPacket($this->username, $session->uuid));
    }
}