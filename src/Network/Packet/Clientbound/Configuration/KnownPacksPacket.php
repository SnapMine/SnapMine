<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class KnownPacksPacket extends ClientboundPacket
{
    public function getId(): int
    {
        return 0x0E;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt(1)
            ->putString("minecraft")
            ->putString("core")
            ->putString("1.21.5");
    }
}