<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\Animal\Animal;
use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Variant\AxolotlVariant;

class Axolotl extends Animal
{
    private AxolotlVariant $variant = AxolotlVariant::LUCY;
    private bool $isPlayingDead = false;
    private bool $fromBucket = false;

    /**
     * @return AxolotlVariant
     */
    public function getVariant(): AxolotlVariant
    {
        return $this->variant;
    }

    /**
     * @param AxolotlVariant $variant
     */
    public function setVariant(AxolotlVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::VAR_INT, $this->variant);
    }

    /**
     * @return bool
     */
    public function isPlayingDead(): bool
    {
        return $this->isPlayingDead;
    }

    /**
     * @param bool $isPlayingDead
     */
    public function setPlayingDead(bool $isPlayingDead): void
    {
        $this->isPlayingDead = $isPlayingDead;

        $this->setMetadata(18, MetadataType::BOOLEAN, $this->isPlayingDead);
    }

    public function isFromBucket(): bool
    {
        return $this->fromBucket;
    }

    public function setFromBucket(bool $fromBucket): void
    {
        $this->fromBucket = $fromBucket;

        $this->setMetadata(19, MetadataType::BOOLEAN, $this->fromBucket);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::AXOLOTL;
    }
}