<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class DisconnectPacket extends ClientboundPacket
{
    public TextComponent $reason;

    public function __construct(TextComponent $reason)
    {
        $this->reason = $reason;
    }

    public function getId(): int
    {
        return 0x1C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putNBT($this->reason->toNBT());
    }
}