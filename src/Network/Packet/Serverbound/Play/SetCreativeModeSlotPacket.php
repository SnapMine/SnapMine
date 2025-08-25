<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use Exception;
use SnapMine\Inventory\ItemStack;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class SetCreativeModeSlotPacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private int $slot;

    /** @phpstan-ignore property.onlyWritten */
    private ItemStack $itemStack;

    public function getId(): int
    {
        return 0x36;
    }


    /**
     * @throws Exception
     */
    public function read(PacketSerializer $serializer): void
    {
        $this->slot = $serializer->getShort();

        $this->itemStack = ItemStack::decode($serializer);
    }

}