<?php

namespace SnapMine\Block\Entity;

use Aternos\Nbt\Tag\CompoundTag;
use SnapMine\Block\BlockType;
use SnapMine\Inventory\Inventory;
use SnapMine\Inventory\InventoryHolder;
use SnapMine\Inventory\InventoryType;
use SnapMine\World\WorldPosition;

class ChestEntity extends BlockEntity implements InventoryHolder
{
    private Inventory $inventory;

    public function __construct(WorldPosition $position)
    {
        parent::__construct($position);

        $this->inventory = new Inventory(InventoryType::GENERIC_9X3);
    }

    public function getType(): BlockType
    {
        return BlockType::CHEST;
    }

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }

    public static function fromNbt(CompoundTag $tag): BlockEntity
    {
        // TODO: Implement fromNbt() method.
    }
}