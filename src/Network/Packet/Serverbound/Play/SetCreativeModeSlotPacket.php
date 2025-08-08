<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Inventory\ItemStack;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetCreativeModeSlotPacket extends ServerboundPacket
{
    private int $slot;
    private ItemStack $itemStack;

    public function getId(): int
    {
        return 0x36;
    }


    /**
     * @throws \Exception
     */
    public function read(PacketSerializer $serializer): void
    {
        $this->slot = $serializer->getShort();

        $this->itemStack = ItemStack::decode($serializer);
    }

}