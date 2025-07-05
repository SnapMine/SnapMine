<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class DisconnectPacket extends Packet
{
    public string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    public function getId(): int
    {
        return 0x1C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->reason);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->reason = $serializer->getString($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        $session->close();
    }
}