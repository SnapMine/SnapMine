<?php

namespace SnapMine\Command\Default;

use SnapMine\Block\Direction;
use SnapMine\Command\Command;
use SnapMine\Entity\Player;
use SnapMine\Inventory\ItemStack;

return Command::new('give', function (Player $player) {
    $block = $player->getWorld()->getBlock($player->getLocation()->addDirection(Direction::DOWN));
    $player->sendMessage("You are standing on " . $block->getMaterial()->getKey());
    $player->give(new ItemStack($block->getMaterial(), 1));
})->build();