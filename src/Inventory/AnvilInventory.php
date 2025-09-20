<?php 

namespace SnapMine\Inventory;

class AnvilInventory extends Inventory
{
    const LEFT_ITEM_SLOT = 0;
    const RIGHT_ITEM_SLOT = 1;
    const OUTPUT_SLOT = 2;

    public function __construct()
    {
        parent::__construct(InventoryType::ANVIL, "Anvil");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getLeftItem(): ItemStack
    {
        return $this->getItem($this::LEFT_ITEM_SLOT);
    }
    public function setLeftItem(ItemStack $item): void
    {
        $this->setItem($this::LEFT_ITEM_SLOT, $item);
    }
    
    public function getRightItem(ItemStack $item): void
    {
        $this->getItem($this::RIGHT_ITEM_SLOT);
    }
    public function setRightItem(ItemStack $item): void
    {
        $this->setItem($this::RIGHT_ITEM_SLOT, $item);
    }

    public function getOutput(ItemStack $item): void
    {
        $this->getItem($this::OUTPUT_SLOT);
    }
    public function setOutput(ItemStack $item): void
    {
        $this->setItem($this::OUTPUT_SLOT, $item);
    }
}