<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;

abstract class Entity
{
    protected int $internalId;
    protected UUID $uuid;

    public function __construct(
        protected Server   $server,
        protected Location $location,
    )
    {
        $this->internalId = $this->server->incrementAndGetId();
        $this->uuid = UUID::generate();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->internalId;
    }

    /**
     * Get entity uuid
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    abstract function getType(): EntityType;
}