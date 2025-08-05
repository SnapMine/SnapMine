<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Position;

class PickItemFromBlockPacket extends Packet
{
    private Position $position;
    private bool $includeData;

    public function getId(): int
    {
        return 0x22;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->position = $serializer->getPosition($buffer, $offset);
        $this->includeData = $serializer->getBool($buffer, $offset);
    }

    public function handle(Session $session): void
    {
    }
}