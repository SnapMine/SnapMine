<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class KeepAlivePacket extends ClientboundPacket
{
    private int $keepAliveId;

    public function __construct(int $keepAliveId = 0)
    {
        $this->keepAliveId = $keepAliveId;
    }

    public function getId(): int
    {
        return 0x26;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putLong($this->keepAliveId);
    }
}