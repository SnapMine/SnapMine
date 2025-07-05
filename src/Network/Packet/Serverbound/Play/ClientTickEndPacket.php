<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ClientTickEndPacket extends Packet
{
    public function getId(): int
    {
        return 0x0B;
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