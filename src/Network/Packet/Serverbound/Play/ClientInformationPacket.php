<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ClientInformationPacket extends Packet
{

    public function getId(): int
    {
        return 0x0C;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $serializer->getString($buffer, $offset);
        $serializer->getByte($buffer, $offset);
        $serializer->getVarInt($buffer, $offset);
        $serializer->getBool($buffer, $offset);
        $serializer->getUnsignedByte($buffer, $offset);
        $serializer->getVarInt($buffer, $offset);
        $serializer->getBool($buffer, $offset);
        $serializer->getBool($buffer, $offset);
        $serializer->getVarInt($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}