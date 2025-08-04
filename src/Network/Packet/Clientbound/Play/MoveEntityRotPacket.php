<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MoveEntityRotPacket extends Packet
{

    public function __construct(
        private readonly Entity $entity,
        private readonly bool $onGround,
    ) {}

    public function getId(): int
    {
        return 0x31;
    }

    public function write(PacketSerializer $serializer): void
    {
        $loc = $this->entity->getLocation();

        $serializer->putVarInt($this->entity->getId());
        $serializer->putAngle($loc->getYaw());
        $serializer->putAngle($loc->getPitch());
        $serializer->putBool($this->onGround);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}