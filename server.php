<?php

require_once 'vendor/autoload.php';

use Nirbose\PhpMcServ\Server;

const ROOT_PATH = __DIR__;

ini_set('memory_limit', '2048M');

$server = new Server("0.0.0.0", 25565);

$server->start();