<?php 

namespace SnapMine\Inventory;

class CraftingInventory extends Inventory
{
    const CRAFTING_SLOT = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    const OUTPUT_SLOT = 0;

    public function __construct()
    {
        parent::__construct(InventoryType::CRAFTING, "Crafting Table");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getCrafting(int $SlotId): ItemStack
    {
        return $this->getItem($this::CRAFTING_SLOT[$SlotId]);
    }
    public function setCrafting(int $SlotId, ItemStack $item): void
    {
        $this->setItem($this::CRAFTING_SLOT[$SlotId], $item);
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