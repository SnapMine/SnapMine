<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class SetCenterChunk extends ClientboundPacket {
    public function getId(): int {
        return 0x57;
    }

    public function write(PacketSerializer $s): void {
        $s->putVarInt(0)
            ->putVarInt(0);
    }

}