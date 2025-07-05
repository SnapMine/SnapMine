<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class KnownPacksPacket extends Packet
{
    public function getId(): int
    {
        return 0x0E;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
    }

    public function write(PacketSerializer $out): void
    {
        $out->putVarInt(1);

        $out->putString("minecraft");
        $out->putString("core");
        $out->putString("1.21.5");
    }

    public function handle(Session $session): void
    {
        // No specific handling required for this packet
    }
}