<?php

namespace SnapMine\Command\Default;

use SnapMine\Block\Direction;
use SnapMine\Command\ArgumentTypes\BrigadierInteger;
use SnapMine\Command\Command;
use SnapMine\Entity\Player;
use SnapMine\Inventory\ItemStack;

function giveStandingOn(Player $player, int $count = 1): void
{
    $block = $player->getWorld()->getBlock($player->getLocation()->addDirection(Direction::DOWN));
    $player->sendMessage("You are standing on " . $block->getMaterial()->getKey());
    $player->give(new ItemStack($block->getMaterial(), $count));
}

return Command::new('give', function (Player $player) {
    giveStandingOn($player);
})
    ->argument("count", new BrigadierInteger(1, 1024), function (Player $player, BrigadierInteger $count) {
        giveStandingOn($player, $count->getValue());
    })
    ->build();