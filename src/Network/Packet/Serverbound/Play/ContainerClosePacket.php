<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class ContainerClosePacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private int $windowId;

    public function getId(): int
    {
        return 0x11;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->windowId = $serializer->getVarInt();
    }

}