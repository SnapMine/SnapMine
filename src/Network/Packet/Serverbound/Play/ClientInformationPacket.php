<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class ClientInformationPacket extends ServerboundPacket
{

    public function getId(): int
    {
        return 0x0C;
    }

    public function read(PacketSerializer $serializer): void
    {
        $serializer->getString();
        $serializer->getByte();
        $serializer->getVarInt();
        $serializer->getBool();
        $serializer->getUnsignedByte();
        $serializer->getVarInt();
        $serializer->getBool();
        $serializer->getBool();
        $serializer->getVarInt();
    }
}