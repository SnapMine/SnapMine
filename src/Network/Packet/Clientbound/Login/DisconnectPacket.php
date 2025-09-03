<?php

namespace SnapMine\Network\Packet\Clientbound\Login;

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class DisconnectPacket extends ClientboundPacket
{
    public function __construct(
        private readonly TextComponent $reason
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString(json_encode($this->reason));
    }

    public function getId(): int
    {
        return 0x00;
    }
}