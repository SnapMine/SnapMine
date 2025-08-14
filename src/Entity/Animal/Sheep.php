<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

class Sheep extends Animal
{
    public function __construct(Server $server, Location $location) {
        parent::__construct($server, $location);
    }

    function getType(): EntityType
    {
        return EntityType::SHEEP;
    }
}