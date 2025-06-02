<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerPositionPacket extends Packet
{
    private float $x;
    private float $feetY;
    private float $z;
    private bool $flags;

    public function getId(): int
    {
        return 0x1C;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->x = $serializer->getDouble($buffer, $offset);
        $this->feetY = $serializer->getDouble($buffer, $offset);
        $this->z = $serializer->getDouble($buffer, $offset);
        $this->flags = $serializer->getBool($buffer, $offset);
    }

    public function write(PacketSerializer $serializer): void
    {
        throw new \Exception("MovePlayerPositionPacket cannot be sent");
    }

    public function handle(Session $session): void
    {
    }
}