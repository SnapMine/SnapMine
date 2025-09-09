<?php

namespace SnapMine\Inventory;

use InvalidArgumentException;

class PlayerInventory extends Inventory
{
    const HELMET_SLOT = 5;
    const CHESTPLATE_SLOT = 6;
    const LEGGINGS_SLOT = 7;
    const BOOTS_SLOT = 8;
    const OFF_HAND_SLOT = 45;
    private int $heldSlot = 0;

    public function __construct()
    {
        parent::__construct(InventoryType::PLAYER, "");
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

    public function setHeldHotbarSlot(int $slot): void
    {
        if ($slot < 0 || $slot > 8) {
            throw new InvalidArgumentException("Held slot must be between 0 and 8");
        }

        $this->heldSlot = $slot;
    }

    public function getHeldHotbarSlot(): int
    {
        return $this->heldSlot;
    }

    public function setHeldItem(ItemStack $item): void
    {
        $this->setItem($this->heldSlot + 36, $item);
    }

    public function getHeldItem(): ItemStack
    {
        return $this->getItem($this->heldSlot + 36);
    }

}