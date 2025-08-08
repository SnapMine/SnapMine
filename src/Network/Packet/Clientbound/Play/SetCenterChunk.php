<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class SetCenterChunk extends ClientboundPacket {
    public function getId(): int {
        return 0x57;
    }

    public function write(PacketSerializer $s): void {
        $s->putVarInt(0)
            ->putVarInt(0);
    }

}