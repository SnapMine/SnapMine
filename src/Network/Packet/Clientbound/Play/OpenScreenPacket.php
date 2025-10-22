<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Component\TextComponent;
use SnapMine\Inventory\InventoryType;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Utils\Nbt;

class OpenScreenPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $windowId,
        private readonly InventoryType $windowType,
        private readonly TextComponent $windowTitle
)
{
}

public function getId(): int
{
    return 0x34;
}

public function write(PacketSerializer $serializer): void
{
    $serializer->putVarInt($this->windowId)
        ->putVarInt($this->windowType->value)
        ->putNBT(Nbt::toNbt($this->windowTitle));
}
}