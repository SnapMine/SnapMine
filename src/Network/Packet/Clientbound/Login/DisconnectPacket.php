<?php

namespace SnapMine\Network\Packet\Clientbound\Login;

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\Nbt;

class DisconnectPacket extends ClientboundPacket
{
    public function __construct(
        private readonly TextComponent $reason
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putNBT(Nbt::toNbt($this->reason));
    }

    public function getId(): int
    {
        return 0x00;
    }
}