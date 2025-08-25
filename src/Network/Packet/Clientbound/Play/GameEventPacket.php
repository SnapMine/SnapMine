<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class GameEventPacket extends ClientboundPacket {

    private int $eventId;
    private float $value;

    public function __construct(int $eventId = 0, float $value = 0.0)
    {
        $this->eventId = $eventId;
        $this->value = $value;
    }

    public function getId(): int
    {
        return 0x22;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putUnsignedByte($this->eventId)
            ->putFloat($this->value);
    }
}