<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PlayerInputPacket extends ServerboundPacket {
    private int $flag;

    public function getId(): int
    {
        return 0x29;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->flag = $serializer->getUnsignedByte();
    }

    public function handle(Session $session): void
    {
    }
}