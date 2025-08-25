<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class MovePlayerStatusOnlyPacket extends ServerboundPacket {
    /** @phpstan-ignore property.onlyWritten */
    private int $flags;

    public function getId(): int
    {
        return 0x1F;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->flags = $serializer->getByte();
    }

    public function write(PacketSerializer $serializer): void
    {

    }

    public function handle(Session $session): void
    {
        
    }
}