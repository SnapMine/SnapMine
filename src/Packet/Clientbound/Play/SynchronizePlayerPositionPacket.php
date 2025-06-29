<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SynchronizePlayerPositionPacket extends Packet
{
    public function __construct(
        private int $entityId,
        private float $x,
        private float $y,
        private float $z,
        private float $velocityX,
        private float $velocityY,
        private float $velocityZ,
        private float $yaw,
        private float $pitch,
        private int $flags = 0x0001 | 0x0002 | 0x0004 | 0x0008 | 0x0010 | 0x0020 | 0x0040 | 0x0080
    ) {}

    public function getId(): int
    {
        return 0x41;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entityId);
        $serializer->putDouble($this->x); // x
        $serializer->putDouble($this->y); // y
        $serializer->putDouble($this->z); // z
        $serializer->putDouble($this->velocityX); // velocityX
        $serializer->putDouble($this->velocityY); // velocityY
        $serializer->putDouble($this->velocityZ); // velocityZ
        $serializer->putFloat($this->yaw); // yaw
        $serializer->putFloat($this->pitch); // pitch
        $serializer->putInt($this->flags); // flags
    }

    public function handle(Session $session): void
    {
    }
}