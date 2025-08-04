<?php

namespace Nirbose\PhpMcServ\Entity;

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
    }

    public function isIgnoreRadius(): bool
    {
        return $this->ignoreRadius;
    }

    public function setIgnoreRadius(bool $ignoreRadius): void
    {
        $this->ignoreRadius = $ignoreRadius;
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