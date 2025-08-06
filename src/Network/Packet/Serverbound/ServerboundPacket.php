<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

abstract class ServerboundPacket implements Packet
{
    abstract public function read(PacketSerializer $serializer): void;

    public function handle(Session $session): void
    {
    }
}