<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Inventory\Inventory;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class ContainerSetContentPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Inventory $inventory,
    )
    {
    }

    public function getId(): int
    {
        return 0x12;
    }

    public function write(PacketSerializer $serializer): void
    {
        $this->inventory->encode($serializer);
    }
}