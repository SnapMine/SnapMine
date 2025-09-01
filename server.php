<?php

require_once 'vendor/autoload.php';

use SnapMine\Command\Default\HelpCommand;
use SnapMine\Command\Default\KickCommand;
use SnapMine\Server;

const ROOT_PATH = __DIR__;

var_dump(repeat_this("coucou", 5, false));

ini_set('memory_limit', '2048M');

$server = new Server();

$server->getCommandManager()->add('help', new HelpCommand());
$server->getCommandManager()->add('kick', new KickCommand());
$server->getCommandManager()->add('spawn', new \SnapMine\Command\Default\SpawnCommand());

$server->start();
