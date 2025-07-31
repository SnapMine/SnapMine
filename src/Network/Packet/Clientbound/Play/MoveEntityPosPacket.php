<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MoveEntityPosPacket extends Packet
{
    public function __construct(
        private readonly int $entityId,
        private readonly int $deltaX,
        private readonly int $deltaY,
        private readonly int $deltaZ,
        private readonly bool $onGround,
    ) {}

    public function getId(): int
    {
        return 0x2E;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entityId);
        $serializer->putShort($this->deltaX);
        $serializer->putShort($this->deltaY);
        $serializer->putShort($this->deltaZ);
        $serializer->putBool($this->onGround);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}