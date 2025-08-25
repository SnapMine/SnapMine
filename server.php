<?php

require_once 'vendor/autoload.php';

use Nirbose\PhpMcServ\Server;
use React\EventLoop\Loop;

const ROOT_PATH = __DIR__;

ini_set('memory_limit', '2048M');

$server = new Server("0.0.0.0", 5000);

$server->start();

// Run ReactPHP event loop
Loop::get()->run();
