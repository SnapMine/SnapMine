<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Block;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Interactable;
use SnapMine\Block\Data\Lightable;
use SnapMine\Block\Direction;
use SnapMine\Entity\Player;
use SnapMine\Inventory\FurnaceInventory;

class Furnace extends BlockData implements Interactable
{
    use Facing, Lightable;

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
        $player->openInventory(new FurnaceInventory());

        return true;
    }
}