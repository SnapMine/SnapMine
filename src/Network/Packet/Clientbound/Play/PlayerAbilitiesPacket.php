<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class PlayerAbilitiesPacket extends ClientboundPacket {
    public function getId(): int
    {
        return 0x39;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putByte(0x08 | 0x04 | 0x02 | 0x01)
            ->putFloat(0.05)
            ->putFloat(0.1);
    }
}