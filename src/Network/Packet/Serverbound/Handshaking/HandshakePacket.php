<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Handshaking;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class HandshakePacket extends ServerboundPacket
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

    public function read(PacketSerializer $serializer): void
    {
        $this->protocolVersion = $serializer->getVarInt();
        $this->serverAddress = $serializer->getString();
        $this->serverPort = $serializer->getUnsignedShort();
        $this->nextState = $serializer->getVarInt();
    }

    public function handle(Session $session): void
    {
        $session->setState($this->nextState);
    }
}