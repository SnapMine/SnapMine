<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Exception;
use Nirbose\PhpMcServ\Inventory\ItemStack;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

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