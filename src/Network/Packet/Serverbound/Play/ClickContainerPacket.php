<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Inventory\ItemStack;
use SnapMine\Material;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolDecodable;
use SnapMine\Session\Session;

class ClickContainerPacket extends ServerboundPacket
{
    private int $windowId;
    private int $stateId;
    private int $slot;
    private int $button;
    private int $mode;

    private array $changedSlots = [];
    private ItemStack $carriedItem;

    public function getId(): int
    {
        return 0x10;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->windowId = $serializer->getVarInt();
        $this->stateId = $serializer->getVarInt();
        $this->slot = $serializer->getShort();
        $this->button = $serializer->getByte();
        $this->mode = $serializer->getVarInt();

        for ($i = 0, $count = $serializer->getVarInt(); $i < $count; $i++) {
            $index = $serializer->getShort();
            $item = $this->readHashedSlot($serializer);
            $this->changedSlots[$index] = $item;
        }

        $this->carriedItem = $this->readHashedSlot($serializer);
    }

    private function readHashedSlot(PacketSerializer $serializer): ItemStack
    {
        $hasItem = $serializer->getBool();

        if (!$hasItem) {
            return ItemStack::empty();
        }

        $itemId = $serializer->getVarInt();
        $itemCount = $serializer->getVarInt();

        $serializer->getPrefixedArray(new class implements ProtocolDecodable {
            public static function decode(PacketSerializer $serializer): ProtocolDecodable
            {
                $serializer->getVarInt();
                $serializer->getInt();
                return new self();
            }
        });

        $serializer->getPrefixedArray(new class implements ProtocolDecodable {
            public static function decode(PacketSerializer $serializer): ProtocolDecodable
            {
                $serializer->getVarInt();
                return new self();
            }
        });

        return new ItemStack(Material::getFromItemId($itemId), $itemCount);
    }

    public function handle(Session $session): void
    {
        if ($this->windowId === 0) {
            $inv = $session->getPlayer()->getInventory();

            foreach ($this->changedSlots as $index => $item) {
                $inv->setItem($index, $item);
            }

            $inv->setCarriedItem($this->carriedItem);
        }
    }
}