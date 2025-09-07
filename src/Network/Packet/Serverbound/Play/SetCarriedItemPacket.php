<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class SetCarriedItemPacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private int $slot;

    public function getId(): int
    {
        return 0x33;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->slot = $serializer->getShort();
    }

    public function handle(Session $session): void
    {
        $session->getPlayer()->getInventory()->setHeldHotbarSlot($this->slot);
    }

}