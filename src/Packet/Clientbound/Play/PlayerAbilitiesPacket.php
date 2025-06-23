<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PlayerAbilitiesPacket extends Packet {
    public function getId(): int
    {
        return 0x39;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putByte(0x08 | 0x04 | 0x02 | 0x01);
        $serializer->putFloat(0.05);
        $serializer->putFloat(0.1);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}