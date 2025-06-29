<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class CustomPlayloadPacket extends Packet {
    private string $channel;
    private string $data;

    public function getId(): int
    {
        return 0x14;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        
    }

    public function write(PacketSerializer $serializer): void
    {
        
    }

    public function handle(Session $session): void
    {
        
    }
}