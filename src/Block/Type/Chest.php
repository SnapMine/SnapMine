<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Block;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Interactable;
use SnapMine\Block\Data\Type;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;
use SnapMine\Entity\Player;
use SnapMine\Inventory\Inventory;
use SnapMine\Inventory\InventoryType;

class Chest extends BlockData implements Interactable
{
    use Facing, Waterlogged, Type;

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    public function interact(Player $player, Block $block): bool
    {
        $player->openInventory(new Inventory(InventoryType::GENERIC_9X3, 'Chest'));

        return true;
    }
}