<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SynchronizePlayerPositionPacket extends Packet
{
    public function getId(): int
    {
        return 0x41;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt(1);
        $serializer->putDouble(0.0); // x
        $serializer->putDouble(0.0); // y
        $serializer->putDouble(0.0); // z
        $serializer->putDouble(0.0); // velocityX
        $serializer->putDouble(0.0); // velocityY
        $serializer->putDouble(0.0); // velocityZ
        $serializer->putFloat(0.0); // yaw
        $serializer->putFloat(0.0); // pitch
        $serializer->putInt(0x0001); // flags
    }

    public function handle(Session $session): void
    {
    }
}