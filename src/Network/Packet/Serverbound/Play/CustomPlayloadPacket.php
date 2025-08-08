<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class CustomPlayloadPacket extends ServerboundPacket {
    private string $channel;
    private string $data;

    public function getId(): int
    {
        return 0x14;
    }

    public function read(PacketSerializer $serializer): void
    {
        
    }
}