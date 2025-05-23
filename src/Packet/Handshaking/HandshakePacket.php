<?php

namespace Nirbose\PhpMcServ\Packet\Handshaking;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class HandshakePacket extends Packet
{
    public int $protocolVersion;
    public string $serverAddress;
    public int $serverPort;
    public int $nextState;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return 0x00;
    }

    public function write(PacketSerializer $serializer): void
    {
        throw new \Exception("Not implemented");
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $serializer->getVarInt($buffer, $offset); // Skip the packet length
        $serializer->getVarInt($buffer, $offset); // Skip the packet ID

        $this->protocolVersion = $serializer->getVarInt($buffer, $offset);
        $this->serverAddress = $serializer->getString($buffer, $offset);
        $this->serverPort = $serializer->getUnsignedShort($buffer, $offset);
        $this->nextState = $serializer->getVarInt($buffer, $offset);
    }
}