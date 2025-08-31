<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\CommandExecutor;
use SnapMine\Entity\Player;

class KickCommand implements CommandExecutor
{

    public function execute(Player $player, string $command): void
    {
        $player->kick('Kick !');
    }
}