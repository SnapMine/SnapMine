<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

class Sheep extends Entity
{
    public function __construct(Server $server) {
        parent::__construct($server, new Location(0, 0, 0));
    }

    function getType(): EntityType
    {
        return EntityType::SHEEP;
    }
}