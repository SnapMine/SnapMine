<?php

namespace SnapMine\Network\Packet\Clientbound\Configuration;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

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