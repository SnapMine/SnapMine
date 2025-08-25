<?php

namespace SnapMine\Entity;

use SnapMine\Utils\UUID;

class GameProfile
{
    public function __construct(
        private readonly string $name,
        private readonly UUID $uuid,
    )
    {
    }

    /**
     * Get uuid
     *
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}