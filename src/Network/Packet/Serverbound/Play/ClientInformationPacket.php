<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

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