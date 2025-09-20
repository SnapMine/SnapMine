<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\ArgumentTypes\ArgumentEntity;
use SnapMine\Command\ArgumentTypes\BrigadierString;
use SnapMine\Command\Command;
use SnapMine\Entity\Player;

return Command::new('kick', function (Player $player) {
    $player->kick('Why not.');
})
    ->group(function ($group) {
      $group->argument('player', new ArgumentEntity(true, true), function (Player $sender, ArgumentEntity $target) {
          $target->getValue()->kick('Kicked by an operator.');
          $sender->sendMessage("Kicked " . $target->getValue()->getName());
      })
          ->argument('reason', new BrigadierString(BrigadierString::GREEDY_PHRASE), function (Player $sender, ArgumentEntity $target, BrigadierString $reason) {
              $target->getValue()->kick($reason->getValue());
              $sender->sendMessage("Kicked " . $target->getValue()->getName() . " for " . $reason->getValue());
          });
    })
    ->build();