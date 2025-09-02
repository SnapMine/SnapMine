<?php

namespace SnapMine\Inventory;

class PlayerInventory extends Inventory
{
    const HELMET_SLOT = 5;
    const CHESTPLATE_SLOT = 6;
    const LEGGINGS_SLOT = 7;
    const BOOTS_SLOT = 8;

    public function __construct()
    {
        parent::__construct(InventoryType::PLAYER);
    }

    public function getWindowId(): int
    {
        return 0;
    }

    public function getHelmet(): ItemStack
    {
        return $this->getItem($this::HELMET_SLOT);
    }

    public function setHelmet(ItemStack $item): void
    {
        $this->setItem($this::HELMET_SLOT, $item);
    }

    public function getChestplate(): ItemStack
    {
        return $this->getItem($this::CHESTPLATE_SLOT);
    }

    public function setChestplate(ItemStack $item): void
    {
        $this->setItem($this::CHESTPLATE_SLOT, $item);
    }

    public function getLeggings(): ItemStack
    {
        return $this->getItem($this::LEGGINGS_SLOT);
    }

    public function setLeggings(ItemStack $item): void
    {
        $this->setItem($this::LEGGINGS_SLOT, $item);
    }

    public function getBoots(): ItemStack
    {
        return $this->getItem($this::BOOTS_SLOT);
    }

    public function setBoots(ItemStack $item): void
    {
        $this->setItem($this::BOOTS_SLOT, $item);
    }
}