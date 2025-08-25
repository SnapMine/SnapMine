<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Entity\Variant\FrogVariant;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

class Frog extends Animal
{
    private FrogVariant $variant;
    private int $tongueTarget = 0;

    public function __construct(
        Server   $server,
        Location $location,
    )
    {
        parent::__construct($server, $location);

        $this->variant = FrogVariant::TEMPERATE();
    }

    /**
     * @return FrogVariant
     */
    public function getVariant(): FrogVariant
    {
        return $this->variant;
    }

    /**
     * @param FrogVariant $variant
     */
    public function setVariant(FrogVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::FROG_VARIANT, $variant->getId());
    }

    /**
     * @return int
     */
    public function getTongueTarget(): int
    {
        return $this->tongueTarget;
    }

    /**
     * @param int $tongueTarget
     */
    public function setTongueTarget(int $tongueTarget): void
    {
        $this->tongueTarget = $tongueTarget;

        $this->setMetadata(18, MetadataType::OPTIONAL_VAR_INT, $this->tongueTarget);
    }

    public function getType(): EntityType
    {
        return EntityType::FROG;
    }
}