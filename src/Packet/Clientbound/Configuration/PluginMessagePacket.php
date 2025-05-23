<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PluginMessagePacket extends Packet
{

    public function __construct()
    {
    }

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString("minecraft:brand");
        $serializer->putVarInt(0);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \Exception("Not implemented");
    }

    public function handle(Session $session): void
    {
    }
}