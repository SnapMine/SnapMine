<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Status;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class PongPacket extends ClientboundPacket
{
    public int $time;

    public function __construct(int $time)
    {
        $this->time = $time;
    }

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putLong($this->time);
    }
}