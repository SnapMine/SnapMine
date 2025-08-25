<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Server;
use SnapMine\World\Location;

class Sheep extends Animal
{
    public function __construct(Server $server, Location $location) {
        parent::__construct($server, $location);
    }

    public function getType(): EntityType
    {
        return EntityType::SHEEP;
    }
}