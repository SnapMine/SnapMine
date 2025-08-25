<?php

namespace SnapMine\Entity;

use SnapMine\Entity\Creature\Creature;
use SnapMine\Entity\Metadata\MetadataType;

abstract class AgeableMob extends Creature
{
    private bool $isBaby = false;

    public function isBaby(): bool
    {
        return $this->isBaby;
    }

    public function setBaby(bool $isBaby): void
    {
        $this->isBaby = $isBaby;

        $this->setMetadata(16, MetadataType::BOOLEAN, $this->isBaby);
    }
}