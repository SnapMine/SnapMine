<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetCenterChunk extends Packet {
    public function getId(): int {
        return 0x57;
    }

    public function write(PacketSerializer $s): void {
        $s->putVarInt(0);
        $s->putVarInt(0);
    }

    public function read(PacketSerializer $s, string $buffer, int &$offset): void {
    }

    public function handle(Session $session): void {
    }
}