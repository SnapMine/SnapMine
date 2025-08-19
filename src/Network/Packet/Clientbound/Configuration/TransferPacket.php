<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class TransferPacket extends ClientboundPacket
{
    public function __construct(
        private readonly string $host,
        private readonly int $port,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putString($this->host)
            ->putVarInt($this->port);
    }

    public function getId(): int
    {
        return 0x0B;
    }
}