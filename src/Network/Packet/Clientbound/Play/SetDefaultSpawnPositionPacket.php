<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

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