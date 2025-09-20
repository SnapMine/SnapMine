<?php 

namespace SnapMine\Inventory;

class EnchantingInventory extends Inventory
{
    const ENCHANTING_ITEM_SLOT = 0;
    const LAPIS_SLOT = 1;

    public function __construct()
    {
        parent::__construct(InventoryType::ENCHANTING, "Enchanting Table");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getEnchantingItem(): ItemStack
    {
        return $this->getItem($this::ENCHANTING_ITEM_SLOT);
    }
    public function setEnchantingItem(ItemStack $item): void
    {
        $this->setItem($this::ENCHANTING_ITEM_SLOT, $item);
    }
    
    public function getLapis(ItemStack $item): void
    {
        $this->getItem($this::LAPIS_SLOT);
    }
    public function setLapis(ItemStack $item): void
    {
        $this->setItem($this::LAPIS_SLOT, $item);
    }
}