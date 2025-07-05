<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Handshaking;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

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
        $this->protocolVersion = $serializer->getVarInt($buffer, $offset);
        $this->serverAddress = $serializer->getString($buffer, $offset);
        $this->serverPort = $serializer->getUnsignedShort($buffer, $offset);
        $this->nextState = $serializer->getVarInt($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        $session->setState($this->nextState);
    }
}