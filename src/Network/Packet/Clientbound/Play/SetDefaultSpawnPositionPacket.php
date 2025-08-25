<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class SetDefaultSpawnPositionPacket extends ClientboundPacket
{
    public function getId(): int
    {
        return 0x5A;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putPosition(0, 64, 0)
            ->putFloat(0.0);
    }

}