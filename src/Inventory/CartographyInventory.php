<?php 

namespace SnapMine\Inventory;

class CartographyInventory extends Inventory
{
    const MAP_SLOT = 0;
    const PAPER_SLOT = 1;
    const OUTPUT_SLOT = 2;

    public function __construct()
    {
        parent::__construct(InventoryType::CARTOGRAPHY_TABLE, "Cartography Table");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getMap(): ItemStack
    {
        return $this->getItem($this::MAP_SLOT);
    }
    public function setMap(ItemStack $item): void
    {
        $this->setItem($this::MAP_SLOT, $item);
    }
    
    public function getPaper(ItemStack $item): void
    {
        $this->getItem($this::PAPER_SLOT);
    }
    public function setPaper(ItemStack $item): void
    {
        $this->setItem($this::PAPER_SLOT, $item);
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