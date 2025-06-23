<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PlayerInputPacket extends Packet {
    private int $flag;

    public function getId(): int
    {
        return 0x29;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->flag = $serializer->getUnsignedByte($buffer, $offset);
    }

    public function handle(Session $session): void
    {
    }
}