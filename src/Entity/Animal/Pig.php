<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Variant\PigVariant;
use SnapMine\Server;
use SnapMine\World\Location;

class Pig extends Animal
{
    private int $timeToBoost = 0;
    private PigVariant $variant;

    public function __construct(Server $server, Location $location)
    {
        parent::__construct($server, $location);

        $this->variant = PigVariant::TEMPERATE();
    }

    /**
     * @return int
     */
    public function getTimeToBoost(): int
    {
        return $this->timeToBoost;
    }

    /**
     * @param int $timeToBoost
     */
    public function setTimeToBoost(int $timeToBoost): void
    {
        $this->timeToBoost = $timeToBoost;

        $this->setMetadata(17, MetadataType::VAR_INT, $this->timeToBoost);
    }

    /**
     * @return PigVariant
     */
    public function getVariant(): PigVariant
    {
        return $this->variant;
    }

    /**
     * @param PigVariant $variant
     */
    public function setVariant(PigVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(18, MetadataType::PIG_VARIANT, $variant->getId());
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::PIG;
    }
}