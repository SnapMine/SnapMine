<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

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