<?php

namespace Nirbose\PhpMcServ\Particle\Vibration;

use Nirbose\PhpMcServ\Entity\Entity;

class EntityDestination implements VibrationDestination
{
    public function __construct(
        private Entity $entity,
    )
    {
    }

    /**
     * @return Entity
     */
    public function getEntity(): Entity
    {
        return $this->entity;
    }
}