<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

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