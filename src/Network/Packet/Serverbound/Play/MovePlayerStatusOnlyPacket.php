<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerStatusOnlyPacket extends ServerboundPacket {
    private int $flags;

    public function getId(): int
    {
        return 0x1F;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->flags = $serializer->getByte();
    }

    public function write(PacketSerializer $serializer): void
    {

    }

    public function handle(Session $session): void
    {
        
    }
}