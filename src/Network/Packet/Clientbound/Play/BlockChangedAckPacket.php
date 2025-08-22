<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class BlockChangedAckPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $sequenceId,
    )
    {

    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->sequenceId);
    }

    public function getId(): int
    {
        return 0x04;
    }
}