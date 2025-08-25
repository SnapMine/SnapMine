<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\World\Position;

class PickItemFromBlockPacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private Position $position;
    /** @phpstan-ignore property.onlyWritten */
    private bool $includeData;

    public function getId(): int
    {
        return 0x22;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->position = $serializer->getPosition();
        $this->includeData = $serializer->getBool();
    }
}