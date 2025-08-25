<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Variant\CowVariant;
use SnapMine\Server;
use SnapMine\World\Location;

class Cow extends Animal
{
    private CowVariant $variant;

    public function __construct(
        Server   $server,
        Location $location,
    )
    {
        parent::__construct($server, $location);

        $this->variant = CowVariant::TEMPERATE();
    }

    /**
     * @return CowVariant
     */
    public function getVariant(): CowVariant
    {
        return $this->variant;
    }

    /**
     * @param CowVariant $variant
     */
    public function setVariant(CowVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::COW_VARIANT, $variant->getId());
    }

    public function getType(): EntityType
    {
        return EntityType::COW;
    }
}