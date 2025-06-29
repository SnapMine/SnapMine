<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetDefaultSpawnPositionPacket extends Packet {
    public function getId(): int
    {
        return 0x5A;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putPosition(0, 64, 0);
        $serializer->putFloat(0.0);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}