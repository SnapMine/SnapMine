<?php

require_once 'vendor/autoload.php';

use Nirbose\PhpMcServ\Core\Server;

$server = new Server("0.0.0.0", 25565);

$server->start();