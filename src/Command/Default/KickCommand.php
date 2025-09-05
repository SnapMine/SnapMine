<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\Command;
use SnapMine\Entity\Player;

return Command::new('kick', function (Player $player) {
    $player->kick('Why not.');
})->build();