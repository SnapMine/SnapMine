<?php 

namespace SnapMine\Inventory;

class LoomInventory extends Inventory
{
    const BANNER_SLOT = 0;
    const DYE_SLOT = 1;
    const PATTERN_SLOT = 2;
    const OUTPUT_SLOT = 3;

    public function __construct()
    {
        parent::__construct(InventoryType::LOOM);
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getBanner(): ItemStack
    {
        return $this->getItem($this::BANNER_SLOT);
    }
    public function setBanner(ItemStack $item): void
    {
        $this->setItem($this::BANNER_SLOT, $item);
    }
    
    public function getDye(ItemStack $item): void
    {
        $this->getItem($this::DYE_SLOT);
    }
    public function setDye(ItemStack $item): void
    {
        $this->setItem($this::DYE_SLOT, $item);
    }

    public function getPattern(): ItemStack
    {
        return $this->getItem($this::PATTERN_SLOT);
    }
    public function setPattern(ItemStack $item): void
    {
        $this->setItem($this::PATTERN_SLOT, $item);
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