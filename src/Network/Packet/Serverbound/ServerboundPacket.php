<?php

namespace SnapMine\Network\Packet\Serverbound;

use SnapMine\Network\Packet\Packet;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

abstract class ServerboundPacket implements Packet
{
    abstract public function read(PacketSerializer $serializer): void;

    public function handle(Session $session): void
    {
    }
}