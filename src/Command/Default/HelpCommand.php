<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\ArgumentTypes\BrigadierInteger;
use SnapMine\Command\ArgumentTypes\BrigadierString;
use SnapMine\Command\Command;
use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Component\TextComponent;
use SnapMine\Entity\Player;
use SnapMine\Utils\DyeColor;

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
            ->literal('hello', function (Player $player) {
                $player->sendMessage(
                    TextComponent::text('Hello ')
                        ->bold(true)
                        ->color(DyeColor::BLUE)
                        ->append(
                            TextComponent::text('World!')
                                ->italic(true)
                                ->color(DyeColor::YELLOW)
                        )
                );
            });
    })
    ->build();

