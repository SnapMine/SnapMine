<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class AddEntityPacket extends Packet
{
    public function __construct(
        private readonly Entity $entity,
        private readonly int $data,
        private readonly int $velocityX,
        private readonly int $velocityY,
        private readonly int $velocityZ,
    )
    {
    }

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $loc = $this->entity->getLocation();

        $serializer->putVarInt($this->entity->getId());
        $serializer->putUUID($this->entity->getUUID());
        $serializer->putVarInt($this->entity->getType()->value);
        $serializer->putDouble($loc->getX());
        $serializer->putDouble($loc->getY());
        $serializer->putDouble($loc->getZ());
        $serializer->putByte(round($loc->getPitch() * 256 / 360));
        $serializer->putByte(round($loc->getYaw() * 256 / 360));
        $serializer->putByte(round($loc->getYaw() * 256 / 360));
        $serializer->putVarInt($this->data);
        $serializer->putShort($this->velocityX);
        $serializer->putShort($this->velocityY);
        $serializer->putShort($this->velocityZ);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        // TODO: Implement read() method.
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}