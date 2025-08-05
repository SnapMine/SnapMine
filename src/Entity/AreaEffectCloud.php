<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Exception\UnimplementException;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

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

    protected function getMetadataPacket(): PacketSerializer
    {
        $packet = parent::getMetadataPacket();

        // Radius
        $packet->putUnsignedByte(8);
        $packet->putVarInt(3);
        $packet->putFloat($this->radius);

        // Ignore radius
        $packet->putUnsignedByte(9);
        $packet->putVarInt(8);
        $packet->putFloat($this->radius);

        // Particle

        return $packet;
    }

    /**
     * @inheritDoc
     */
    function getType(): EntityType
    {
        return EntityType::AREA_EFFECT_CLOUD;
    }
}