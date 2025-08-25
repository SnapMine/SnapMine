<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class PlayerInputPacket extends ServerboundPacket {
    /** @phpstan-ignore property.onlyWritten */
    private int $flag;

    public function getId(): int
    {
        return 0x29;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->flag = $serializer->getUnsignedByte();
    }

    public function handle(Session $session): void
    {
    }
}