<?php

require_once "vendor/autoload.php";

$server = new \SnapMine\Server('0.0.0.0', '25565');

$server->chunkAsync->request(0, 0);
$server->chunkAsync->request(1, 0);
$server->chunkAsync->request(0, 1);

echo "test ?\n";
//var_dump(\SnapMine\Manager\ChunkManager\ChunkAsync::$queue);

$server->chunkAsync->request(0, 2);

//\Revolt\EventLoop::repeat(0.001, function () use ($server) {
//    $server->chunkAsync->tick();
//});

\Revolt\EventLoop::run();
