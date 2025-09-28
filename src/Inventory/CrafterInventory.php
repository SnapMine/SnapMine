<?php

namespace SnapMine\Inventory;

class CrafterInventory extends Inventory
{
    public function __construct()
    {
        parent::__construct(InventoryType::CRAFTER_3X3, "Crafter");
    }
}