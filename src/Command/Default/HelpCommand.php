<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\Attributes\Argument;
use SnapMine\Command\Attributes\Command;
use SnapMine\Command\Attributes\SubCommand;
use SnapMine\Entity\Player;

#[Command('help')]
class HelpCommand
{

    #[SubCommand]
    public function execute(Player $player, #[Argument] string $command): void
    {
        $player->sendMessage("Hello World!");
    }
}