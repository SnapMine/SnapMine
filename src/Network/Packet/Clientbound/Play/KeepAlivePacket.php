<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class KeepAlivePacket extends ClientboundPacket
{
    private int $keepAliveId;

    public function __construct(int $keepAliveId = 0)
    {
        $this->keepAliveId = $keepAliveId;
    }

    public function getId(): int
    {
        return 0x26;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putLong($this->keepAliveId);
    }
}