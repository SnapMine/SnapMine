<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Entity\Variant\CowVariant;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

class Cow extends Entity
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

    function getType(): EntityType
    {
        return EntityType::COW;
    }
}