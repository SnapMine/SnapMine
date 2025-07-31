<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SynchronizePlayerPositionPacket extends Packet
{
    public function __construct(
        private int $entityId,
        private Player $player,
        private float $velocityX,
        private float $velocityY,
        private float $velocityZ,
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
        $loc = $this->player->getLocation();

        $serializer->putVarInt($this->entityId);
        $serializer->putDouble($loc->getX()); // x
        $serializer->putDouble($loc->getY()); // y
        $serializer->putDouble($loc->getZ()); // z
        $serializer->putDouble($this->velocityX); // velocityX
        $serializer->putDouble($this->velocityY); // velocityY
        $serializer->putDouble($this->velocityZ); // velocityZ
        $serializer->putFloat($loc->getYaw()); // yaw
        $serializer->putFloat($loc->getPitch()); // pitch
        $serializer->putInt($this->flags); // flags
    }

    public function handle(Session $session): void
    {
    }
}