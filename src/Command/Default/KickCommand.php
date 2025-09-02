<?php

namespace SnapMine\Command\Default;

use SnapMine\Command\Command;
use SnapMine\Command\CommandExecutor;
use SnapMine\Entity\Player;

class KickCommand
{
    public function __construct()
    {
        parent::__construct();
    }

    protected array $permissions = ['snapmine.command.kick'];
    public function run(Player $player, string $command): void
    {
        $player->kick('Kick !');
    }
}