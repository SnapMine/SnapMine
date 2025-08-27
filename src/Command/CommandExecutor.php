<?php

namespace SnapMine\Command;

use SnapMine\Entity\Player;

interface CommandExecutor
{
    public function execute(Player $player, string $command): void;
}