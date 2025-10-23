<?php

require_once 'vendor/autoload.php';

const ROOT_PATH = __DIR__;

ini_set('memory_limit', '2048M');

server()->loadCommands(ROOT_PATH . '/Command/Default/');

try {
    server()->start();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
