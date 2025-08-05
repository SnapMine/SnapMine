<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

class Sheep extends Entity
{
    public function __construct(Server $server, Location $location) {
        parent::__construct($server, $location);
    }

    function getType(): EntityType
    {
        return EntityType::SHEEP;
    }
}