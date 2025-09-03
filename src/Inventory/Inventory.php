<?php

namespace SnapMine\Inventory;

use InvalidArgumentException;
use SnapMine\Entity\Player;
use SnapMine\Material;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;

class Inventory implements ProtocolEncodable
{
    private int $windowId = 0;
    private int $stateId = 0;
    /** @var array<null|ItemStack> */
    private array $contents = [];
    private ?ItemStack $carriedItem = null;

    public function getCarriedItem(): ?ItemStack
    {
        return $this->carriedItem;
    }

    public function setCarriedItem(?ItemStack $carriedItem): void
    {
        $this->carriedItem = $carriedItem;
    }

    public function __construct(
        private readonly InventoryType $type,
    )
    {
        for ($i = 0; $i < $this->type->getSize(); $i++) {
            $this->contents[$i] = null;
        }
    }

    /**
     * @return int
     */
    public function getWindowId(): int
    {
        return $this->windowId;
    }

    /**
     * @return InventoryType
     */
    public function getType(): InventoryType
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * @param array $contents
     */
    public function setContents(array $contents): void
    {
        if (count($contents) !== $this->type->getSize()) {
            throw new InvalidArgumentException("Contents size must be equal to inventory size");
        }

        $this->contents = $contents;
    }

    public function getItem(int $index): ItemStack
    {
        if ($this->contents[$index] == null) {
            return ItemStack::empty();
        }

        return $this->contents[$index];
    }

    public function setItem(int $index, ItemStack $item): void
    {
        $this->contents[$index] = $item;
    }

    public function clear(int $index): void
    {
        $this->contents[$index] = null;
    }

    public function isEmpty(): bool
    {
        foreach ($this->contents as $content) {
            if (!is_null($content)) {
                return false;
            }
        }

        return true;
    }

    public function first(Material $material): int
    {
        for ($i = 0; $i < 46; $i++) {
            if ($this->contents[$i] != null && $this->contents[$i]->getMaterial() === $material && $this->contents[$i]->getAmount() < 64) {
                return $i;
            }
        }

        return -1;
    }

    public function addItem(ItemStack $itemStack): void
    {
        $itemStack = clone $itemStack;
        $first = $this->first($itemStack->getMaterial());

        if ($first !== -1) {
            $currentItem = $this->getItem($first);
            $newAmount = $currentItem->getAmount() + $itemStack->getAmount();

            $currentItem->setAmount(min(64, $newAmount));
            $this->setItem($first, $currentItem);

            if ($newAmount > 64) {
                $itemStack->setAmount($itemStack->getAmount() - 64);
                $this->addItem($itemStack);
            }
        } else {
            $first = $this->firstEmpty();

            if ($first !== -1) {
                $this->setItem($first, $itemStack);
            }
        }


    }

    public function firstEmpty(): int
    {
        for ($i = 9; $i < 46; $i++) {
            if ($this->contents[$i] == null) {
                return $i;
            }
        }

        return -1;
    }

    public function getSize(): int
    {
        return $this->type->getSize();
    }

    public function encode(PacketSerializer $serializer): void
    {
        $serializer
            ->putVarInt($this->getWindowId())
            ->putVarInt($this->stateId)
            ->putVarInt(count($this->contents));

        foreach ($this->contents as $content) {
            if (is_null($content)) {
                $content = ItemStack::empty();
            }

            $content->encode($serializer);
        }

        if (is_null($this->carriedItem))
            ItemStack::empty()->encode($serializer);
        else
            $this->carriedItem->encode($serializer);
    }
}