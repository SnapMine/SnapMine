<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ContainerClosePacket extends Packet
{
    private int $windowId;

    public function getId(): int
    {
        return 0x11;
    }

    public function write(PacketSerializer $serializer): void
    {
        // TODO: Implement write() method.
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->windowId = $serializer->getVarInt($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}