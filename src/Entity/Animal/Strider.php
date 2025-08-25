<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;

class Strider extends Animal
{
    private int $boost = 0;
    private bool $shaking = false;

    /**
     * @return int
     */
    public function getBoost(): int
    {
        return $this->boost;
    }

    /**
     * @param int $boost
     */
    public function setBoost(int $boost): void
    {
        $this->boost = $boost;

        $this->setMetadata(17, MetadataType::VAR_INT, $boost);
    }

    /**
     * @return bool
     */
    public function isShaking(): bool
    {
        return $this->shaking;
    }

    /**
     * @param bool $shaking
     */
    public function setShaking(bool $shaking): void
    {
        $this->shaking = $shaking;

        $this->setMetadata(18, MetadataType::BOOLEAN, $this->shaking);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::STRIDER;
    }
}