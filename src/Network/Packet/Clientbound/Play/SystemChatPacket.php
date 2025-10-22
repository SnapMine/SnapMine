<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\Nbt;

class SystemChatPacket extends ClientboundPacket
{
    public function __construct(
        private readonly TextComponent $component,
        private readonly bool $overlay,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putNBT(Nbt::toNbt($this->component))
            ->putBool($this->overlay);
    }

    public function getId(): int
    {
        return 0x72;
    }
}