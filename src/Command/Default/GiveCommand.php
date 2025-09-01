<?php

namespace SnapMine\Command\Default;

use SnapMine\Block\Direction;
use SnapMine\Command\CommandExecutor;
use SnapMine\Entity\Player;
use SnapMine\Inventory\ItemStack;

class GiveCommand implements CommandExecutor
{

    public function execute(Player $player, string $command): void
    {
        $block = $player->getWorld()->getBlock($player->getLocation()->addDirection(Direction::DOWN));
        $player->sendMessage("You are standing on " . $block->getMaterial()->getKey());
        $player->give(new ItemStack($block->getMaterial(), 1));

    }
}