<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class TestPacket extends Packet
{
    public function getId(): int
    {
        return 0x0B; // Replace with the actual packet ID
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        // Implement writing logic if necessary
        // For example, you can send some test data here
    }

    public function handle(Session $session): void
    {
    }
}