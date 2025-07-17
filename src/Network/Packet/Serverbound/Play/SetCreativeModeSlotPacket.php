<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Inventory\ItemStack;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetCreativeModeSlotPacket extends Packet
{
    private int $slot;
    private ItemStack $itemStack;

    public function getId(): int
    {
        return 0x36;
    }

    public function write(PacketSerializer $serializer): void
    {
        // TODO: Implement write() method.
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->slot = $serializer->getShort($buffer, $offset);

        $buffer = substr($buffer, $offset);

        $this->itemStack = ItemStack::decode($buffer);
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}