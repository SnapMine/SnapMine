<?php

namespace SnapMine\Network\Packet\Serverbound\Login;

use SnapMine\Network\Packet\Clientbound\Configuration\KnownPacksPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\ServerState;
use SnapMine\Session\Session;

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