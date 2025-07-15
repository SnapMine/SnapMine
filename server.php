<?php

require_once 'vendor/autoload.php';

use Nirbose\PhpMcServ\Extras\Auth\MojangAuth;
use Nirbose\PhpMcServ\Server;

MojangAuth::init();
$server = new Server("0.0.0.0", 25565);

$server->start();