<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class RotateHeadPacket extends Packet
{
    public function __construct(
        private readonly Entity $entity,
    ) {
    }

    public function getId(): int
    {
        return 0x4C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entity->getId());
        $serializer->putAngle($this->entity->getLocation()->getYaw());
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}