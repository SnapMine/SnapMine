<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;

class PlayerLoadedPacket extends Packet {
    public function getId() : int {
        return 0x2A;
    }

    public function write(\Nirbose\PhpMcServ\Network\Serializer\PacketSerializer $serializer): void {
    }

    public function read(\Nirbose\PhpMcServ\Network\Serializer\PacketSerializer $serializer, string $buffer, int &$offset): void {
    }

    public function handle(\Nirbose\PhpMcServ\Session\Session $session): void {
    }
}