<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class KeepAlivePacket extends Packet {
    private int $keepAliveId;

    public function getId(): int {
        return 0x1A;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->keepAliveId = $serializer->getLong($buffer, $offset);
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function handle(Session $session): void
    {
        
    }
}