<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Block\Block;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\World\Position;

class BlockUpdatePacket extends ClientboundPacket
{
    public function __construct(
        private readonly Position $position,
        private readonly Block $block,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putPosition($this->position)
            ->putVarInt($this->block->getBlockData()->computedId());
    }

    public function getId(): int
    {
        return 0x08;
    }
}