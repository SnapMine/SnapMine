<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

abstract class ClientboundPacket implements Packet
{
    abstract public function write(PacketSerializer $serializer): void;

    public function handle(Session $session): void
    {
    }
}