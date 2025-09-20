<?php 

namespace SnapMine\Inventory;

class FurnaceInventory extends Inventory
{
    const INGREDIENT_SLOT = 0;
    const FUEL_SLOT = 1;
    const OUTPUT_SLOT = 2;

    public function __construct()
    {
        parent::__construct(InventoryType::FURNACE, "Furnace");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getIngredient(): ItemStack
    {
        return $this->getItem($this::INGREDIENT_SLOT);
    }
    public function setIngredient(ItemStack $item): void
    {
        $this->setItem($this::INGREDIENT_SLOT, $item);
    }
    
    public function getFuel(ItemStack $item): void
    {
        $this->getItem($this::FUEL_SLOT);
    }
    public function setFuel(ItemStack $item): void
    {
        $this->setItem($this::FUEL_SLOT, $item);
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