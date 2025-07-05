<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SwingPacket extends Packet {
    private int $hand;

    public function getId(): int {
        return 0x3B;
    }

    public function write(PacketSerializer $serializer): void {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void {
        $this->hand = $serializer->getVarInt($buffer, $offset);
    }

    public function handle(Session $session): void {
    }
}