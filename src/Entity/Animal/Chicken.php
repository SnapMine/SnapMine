<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Variant\ChickenVariant;
use SnapMine\Server;
use SnapMine\World\Location;

class Chicken extends Animal
{
    private ChickenVariant $variant;

    public function __construct(
        Server   $server,
        Location $location,
    )
    {
        parent::__construct($server, $location);

        $this->variant = ChickenVariant::TEMPERATE();
    }

    /**
     * @return ChickenVariant
     */
    public function getVariant(): ChickenVariant
    {
        return $this->variant;
    }

    /**
     * @param ChickenVariant $variant
     */
    public function setVariant(ChickenVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::CHICKEN_VARIANT, $variant->getId());
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::CHICKEN;
    }
}