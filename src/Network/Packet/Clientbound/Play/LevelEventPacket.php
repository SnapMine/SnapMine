<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\World\Position;

class LevelEventPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $event,
        private readonly Position $position,
        private readonly int $data,
        private readonly bool $disableRelativeVolume = false,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putInt($this->event)
            ->putPosition($this->position)
            ->putInt($this->data)
            ->putBool($this->disableRelativeVolume);
    }

    public function getId(): int
    {
        return 0x28;
    }
}