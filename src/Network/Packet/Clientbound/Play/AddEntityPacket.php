<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;

class AddEntityPacket extends Packet
{
    public function __construct(
        private readonly int $entityId,
        private readonly UUID $uuid,
        private readonly EntityType $type,
        private readonly Location $loc,
        private readonly int $headYam,
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
        $serializer->putVarInt($this->entityId + 1);
        $serializer->putUUID($this->uuid);
        $serializer->putVarInt($this->type->value);
        $serializer->putDouble($this->loc->getX());
        $serializer->putDouble($this->loc->getY());
        $serializer->putDouble($this->loc->getZ());
        $serializer->putByte($this->loc->getPitch() * 256 / 360);
        $serializer->putByte($this->loc->getYaw() * 256 / 360);
        $serializer->putByte($this->headYam * 256 / 360);
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