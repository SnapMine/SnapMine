<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetCarriedItemPacket extends Packet
{
    private int $slot;

    public function getId(): int
    {
        return 0x33;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->slot = $serializer->getShort($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}