<?php 

namespace SnapMine\Inventory;

class SmithingInventory extends Inventory
{
    const TEMPLATE_SLOT = 0;
    const BASE_ITEM_SLOT = 1;
    const ADDITIONAL_ITEM_SLOT = 2;
    const OUTPUT_SLOT = 3;

    public function __construct()
    {
        parent::__construct(InventoryType::SMITHING, "Smithing Table");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getTemplate(): ItemStack
    {
        return $this->getItem($this::TEMPLATE_SLOT);
    }
    public function setTemplate(ItemStack $item): void
    {
        $this->setItem($this::TEMPLATE_SLOT, $item);
    }
    
    public function getBaseItem(ItemStack $item): void
    {
        $this->getItem($this::BASE_ITEM_SLOT);
    }
    public function setBaseItem(ItemStack $item): void
    {
        $this->setItem($this::BASE_ITEM_SLOT, $item);
    }
    
    public function getAdditionalItem(ItemStack $item): void
    {
        $this->getItem($this::ADDITIONAL_ITEM_SLOT);
    }
    public function setAdditionalItem(ItemStack $item): void
    {
        $this->setItem($this::ADDITIONAL_ITEM_SLOT, $item);
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