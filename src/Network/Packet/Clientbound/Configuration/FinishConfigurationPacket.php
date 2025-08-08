<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class FinishConfigurationPacket extends ClientboundPacket
{
    public function getId(): int
    {
        return 0x03;
    }

    public function write(PacketSerializer $serializer): void
    {
    }
}