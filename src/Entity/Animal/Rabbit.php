<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Variant\RabbitVariant;

class Rabbit extends Animal
{
    private RabbitVariant $variant = RabbitVariant::BLACK;

    /**
     * @return RabbitVariant
     */
    public function getVariant(): RabbitVariant
    {
        return $this->variant;
    }

    /**
     * @param RabbitVariant $variant
     */
    public function setVariant(RabbitVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::VAR_INT, $this->variant);
    }

    public function getType(): EntityType
    {
        return EntityType::RABBIT;
    }
}