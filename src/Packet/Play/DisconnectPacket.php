<?php

namespace Nirbose\PhpMcServ\Packet\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class DisconnectPacket extends Packet
{
    public string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    public function getId(): int
    {
        return 0x1C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->reason);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->reason = $serializer->getString($buffer, $offset);
    }
}