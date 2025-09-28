<?php 

namespace SnapMine\Inventory;

class BeaconInventory extends Inventory
{
    const PAYMENT_SLOT = 0;

    public function __construct()
    {
        parent::__construct(InventoryType::BEACON, "Beacon");
    }

    public function getWindowId(): int
    {
        return 1;
    }

    public function getPayment(): ItemStack
    {
        return $this->getItem($this::PAYMENT_SLOT);
    }
    public function setPayment(ItemStack $item): void
    {
        $this->setItem($this::PAYMENT_SLOT, $item);
    }
}