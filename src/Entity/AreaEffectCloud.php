<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Exception\UnimplementException;

class AreaEffectCloud extends Entity
{
    private float $radius = 3.0;
    private bool $ignoreRadius = false;

    public function getRadius(): float
    {
        return $this->radius;
    }

    public function setRadius(float $radius): void
    {
        $this->radius = $radius;

        $this->setMetadata(8, MetadataType::FLOAT, $this->radius);
    }

    public function isIgnoreRadius(): bool
    {
        return $this->ignoreRadius;
    }

    public function setIgnoreRadius(bool $ignoreRadius): void
    {
        $this->ignoreRadius = $ignoreRadius;

        $this->setMetadata(9, MetadataType::BOOLEAN, $this->ignoreRadius);
    }

    public function getParticle()
    {
        throw new UnimplementException();
    }

    public function setParticle()
    {
        throw new UnimplementException();
    }

    /**
     * @inheritDoc
     */
    function getType(): EntityType
    {
        return EntityType::AREA_EFFECT_CLOUD;
    }
}