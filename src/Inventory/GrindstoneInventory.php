<?php 

namespace SnapMine\Inventory;

class GrindstoneInventory extends Inventory
{
    const UPPER_ITEM_SLOT = 0;
    const LOWER_ITEM_SLOT = 1;
    const OUTPUT_SLOT = 2;

    public function __construct()
    {
        parent::__construct(InventoryType::GRINDSTONE);
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getUpperItem(): ItemStack
    {
        return $this->getItem($this::UPPER_ITEM_SLOT);
    }
    public function setUpperItem(ItemStack $item): void
    {
        $this->setItem($this::UPPER_ITEM_SLOT, $item);
    }
    
    public function getLowerItem(ItemStack $item): void
    {
        $this->getItem($this::LOWER_ITEM_SLOT);
    }
    public function setLowerItem(ItemStack $item): void
    {
        $this->setItem($this::LOWER_ITEM_SLOT, $item);
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