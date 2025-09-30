<?php

require_once 'vendor/autoload.php';

use SnapMine\Server;

const ROOT_PATH = __DIR__;

ini_set('memory_limit', '2048M');

$server = new Server();

require 'src/Command/Default/HelpCommand.php';
require 'src/Command/Default/SendCommand.php';
require 'src/Command/Default/KickCommand.php';
require 'src/Command/Default/SpawnCommand.php';
require 'src/Command/Default/GiveCommand.php';
require 'src/Command/Default/DebugCommand.php';
require 'src/Command/Default/TeleportCommand.php';

try {
    $server->start();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
