<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\CommandExecutor;
use SnapMine\Entity\EntityType;
use SnapMine\Entity\Player;

class SpawnCommand implements CommandExecutor
{

    public function execute(Player $player, string $command): void
    {
        $player->getLocation()->getWorld()->spawnEntity(EntityType::COW, $player->getLocation());
    }
}