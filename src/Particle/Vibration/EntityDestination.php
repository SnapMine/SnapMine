<?php

namespace SnapMine\Particle\Vibration;

use SnapMine\Entity\Entity;

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