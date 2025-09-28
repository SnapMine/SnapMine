<?php 

namespace SnapMine\Inventory;

class BrewingStandInventory extends Inventory
{
    const BOTTLE_SLOT = [0,1,2];
    const INGREDIENT_SLOT = 3;
    const FUEL_SLOT = 4;

    public function __construct()
    {
        parent::__construct(InventoryType::BREWING_STAND, "Brewing Stand");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getBottleSlot(int $BottleId): ItemStack
    {
        return $this->getItem($this::BOTTLE_SLOT[$BottleId]);
    }
    public function setBottleSlot(ItemStack $item, int $BottleId): void
    {
        $this->setItem($this::BOTTLE_SLOT[$BottleId], $item);
    }
    
    public function getIngredient(ItemStack $item): void
    {
        $this->getItem($this::INGREDIENT_SLOT);
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
}