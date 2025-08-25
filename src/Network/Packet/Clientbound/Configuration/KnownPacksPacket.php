<?php

namespace SnapMine\Network\Packet\Clientbound\Configuration;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

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