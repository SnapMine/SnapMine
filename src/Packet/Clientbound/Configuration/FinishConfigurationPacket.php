<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class FinishConfigurationPacket extends Packet
{
    public function getId(): int
    {
        return 0x03;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
        // No data to read for this packet
    }

    public function write(PacketSerializer $out): void
    {
        // No data to write for this packet
    }

    public function handle(Session $session): void
    {
    }
}