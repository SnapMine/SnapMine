<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerPositionRotationPacket extends Packet
{

    private float $x;
    private float $feetY;
    private float $z;
    private float $yaw;
    private float $pitch;
    private bool $flags;

    public function getId(): int
    {
        return 0x1D;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->x = $serializer->getDouble($buffer, $offset);
        $this->feetY = $serializer->getDouble($buffer, $offset);
        $this->z = $serializer->getDouble($buffer, $offset);
        $this->yaw = $serializer->getFloat($buffer, $offset);
        $this->pitch = $serializer->getFloat($buffer, $offset);
        $this->flags = $serializer->getByte($buffer, $offset);
    }

    public function write(PacketSerializer $serializer): void
    {
        // This packet is not meant to be sent
        throw new \Exception("MovePlayerPositionRotationPacket cannot be sent");
    }

    public function handle(Session $session): void
    {
    }
}