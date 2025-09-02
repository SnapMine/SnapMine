<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\ArgumentTypes\BrigadierString;
use SnapMine\Command\Attributes\Argument;
use SnapMine\Command\Attributes\Command;
use SnapMine\Command\Attributes\SubCommand;
use SnapMine\Entity\Player;

#[Command('help')]
class HelpCommand
{

    #[SubCommand]
    public function execute(Player $player, #[Argument(BrigadierString::GREEDY_PHRASE)] BrigadierString $command): void
    {
        $player->sendMessage($command->getValue());
    }
}