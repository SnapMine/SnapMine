<?php

namespace SnapMine\Inventory;

interface InventoryHolder
{
    public function getInventory(): Inventory;
}