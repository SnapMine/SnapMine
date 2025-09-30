<?php

use SnapMine\Command\ArgumentTypes\ArgumentEntity;
use SnapMine\Command\ArgumentTypes\ArgumentVec3;
use SnapMine\Command\Command;
use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Entity\Player;
use SnapMine\World\Location;

return Command::new('tp')
    ->group(function (CommandNode $group) {
        $group->argument('target', new ArgumentEntity(), function (Player $sender, ArgumentEntity $target) {
            $sender->teleport($target->getValue());
        });
    })
    ->group(function (CommandNode $group) {
        $group->argument('destination', new ArgumentVec3(), function (Player $sender, ArgumentVec3 $target) {
            $world = $sender->getWorld();
            $loc = Location::fromPosition($world, $target->getValue());

            $sender->teleport($loc);
        });
    })->build();
