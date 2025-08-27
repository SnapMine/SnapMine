<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\CommandExecutor;
use SnapMine\Entity\Player;

class HelpCommand implements CommandExecutor
{
    public function execute(Player $player, string $command): void
    {
        $player->sendMessage("Hello World!");
    }
}