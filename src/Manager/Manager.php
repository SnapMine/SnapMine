<?php

namespace SnapMine\Manager;

use SnapMine\Server;

interface Manager
{
    public function tick(Server $server): void;
}