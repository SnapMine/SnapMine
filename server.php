<?php

require_once 'vendor/autoload.php';

use SnapMine\Server;

const ROOT_PATH = __DIR__;

ini_set('memory_limit', '2048M');

$server = new Server();

require 'src/Command/Default/HelpCommandGroup.php';
require 'src/Command/Default/SendCommand.php';
//$server->getCommandManager()->add('kick', new KickCommand());
//$server->getCommandManager()->add('spawn', new \SnapMine\CommandNode\Default\SpawnCommand());
//$server->getCommandManager()->add('give', new \SnapMine\CommandNode\Default\GiveCommand());

$server->start();
