<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\Attributes\Command;
use SnapMine\Command\Attributes\SubCommand;
use SnapMine\Entity\Player;

#[Command('help')]
class HelpCommand
{



//    #[SubCommand]
//    public function execute(Player $player, #[Argument(BrigadierString::GREEDY_PHRASE)] BrigadierString $command): void
//    {
//        $player->sendMessage($command->getValue());
//    }

    #[SubCommand]
    public function execute(Player $player, string $command): void
    {
        $player->sendMessage("Command: " . $command);
    }


    #[SubCommand("coucou")]
    public function executeCoucou(Player $player, string $command): void
    {
        $player->sendMessage("Coucou");
    }


    #[SubCommand("salut")]
    public function executeSalut(Player $player, string $command): void
    {
        $player->sendMessage("Salut: " . $command);
    }
}