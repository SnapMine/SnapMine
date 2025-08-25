<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class ConfirmTeleportationPacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private int $teleportId;

    public function getId(): int
    {
        return 0x00;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->teleportId = $serializer->getVarInt();
    }
}