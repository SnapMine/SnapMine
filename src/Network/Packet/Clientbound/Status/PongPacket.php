<?php

namespace SnapMine\Network\Packet\Clientbound\Status;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class PongPacket extends ClientboundPacket
{
    public int $time;

    public function __construct(int $time)
    {
        $this->time = $time;
    }

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putLong($this->time);
    }
}