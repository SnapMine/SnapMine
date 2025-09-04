<?php

namespace SnapMine\Command\Default;

use SnapMine\Artisan;
use SnapMine\Command\ArgumentTypes\BrigadierInteger;
use SnapMine\Command\ArgumentTypes\BrigadierString;
use SnapMine\Command\Command;
use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Entity\Player;

Command::new('help')
    ->group(function (CommandNode $group) {
        $group
            ->literal('repeat')
            ->arguments(
                [
                    'message' => new BrigadierString(BrigadierString::QUOTABLE_PHRASE),
                    'n' => new BrigadierInteger(1, 20),
                ],
                function (Player $player, BrigadierString $str, BrigadierInteger $n) {
                    for ($i = 0; $i < $n->getValue(); $i++) {
                        $player->sendMessage($i . ": " . $str);
                    }
                }
            );
    })
    ->group(function (CommandNode $group) {
        $group
            ->literal('hello', fn (Player $player) => $player->sendMessage("Hello World!"));
    })
    ->build();

