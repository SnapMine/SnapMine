<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Login;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration\KnownPacksPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Session\Session;

class LoginAcknowledgedPacket extends ServerboundPacket
{
    public function getId(): int
    {
        return 0x03;
    }

    public function read(PacketSerializer $serializer): void
    {
    }

    public function handle(Session $session): void
    {
        $session->setState(ServerState::CONFIGURATION);

        $session->sendPacket(new KnownPacksPacket());
    }
}