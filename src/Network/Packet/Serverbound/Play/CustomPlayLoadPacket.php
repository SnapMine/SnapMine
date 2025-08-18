<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class CustomPlayLoadPacket extends ServerboundPacket {

    public function getId(): int
    {
        return 0x14;
    }

    public function read(PacketSerializer $serializer): void
    {
        
    }
}