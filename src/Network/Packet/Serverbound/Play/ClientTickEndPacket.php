<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Packet;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class ClientTickEndPacket extends ServerboundPacket
{
    public function getId(): int
    {
        return 0x0B;
    }

    public function read(PacketSerializer $serializer): void
    {
    }

}