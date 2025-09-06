<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\Command;
use SnapMine\Entity\EntityType;
use SnapMine\Entity\Player;

return Command::new('spawn', function (Player $player) {
    $player->getLocation()->getWorld()->spawnEntity(EntityType::COW, $player->getLocation());
})->build();