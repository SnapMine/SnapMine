<?php

namespace SnapMine\Network\Packet\Clientbound;

use SnapMine\Network\Packet\Packet;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

abstract class ClientboundPacket implements Packet
{
    abstract public function write(PacketSerializer $serializer): void;

    public function handle(Session $session): void
    {
    }
}