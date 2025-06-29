<?php

namespace Nirbose\PhpMcServ\Manager;

use Nirbose\PhpMcServ\Server;

interface Manager
{
    public function tick(Server $server): void;
}