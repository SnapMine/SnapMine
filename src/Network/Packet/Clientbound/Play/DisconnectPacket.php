<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class DisconnectPacket extends ClientboundPacket
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

    public function handle(Session $session): void
    {
        $session->close();
    }
}