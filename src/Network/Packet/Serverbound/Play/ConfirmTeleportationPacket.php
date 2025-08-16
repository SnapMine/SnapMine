<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class ConfirmTeleportationPacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private int $teleportId;

    public function getId(): int
    {
        return 0x00;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->teleportId = $serializer->getVarInt();
    }
}