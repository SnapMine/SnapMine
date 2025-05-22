<?php

namespace Nirbose\PhpMcServ\Packet\Status;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class PongPacket extends Packet
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

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->time = $serializer->getLong($buffer, $offset);
    }
}