<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Block\Block;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\World\Position;

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