<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

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