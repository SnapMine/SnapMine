<?php 

namespace SnapMine\Inventory;

class StoneCutterInventory extends Inventory
{
    const INPUT_SLOT = 0;
    const OUTPUT_SLOT = 1;

    public function __construct()
    {
        parent::__construct(InventoryType::STONECUTTER, "Stonecutter");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getInput(): ItemStack
    {
        return $this->getItem($this::INPUT_SLOT);
    }
    public function setInput(ItemStack $item): void
    {
        $this->setItem($this::INPUT_SLOT, $item);
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