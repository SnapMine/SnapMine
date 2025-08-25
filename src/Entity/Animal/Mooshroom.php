<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Variant\MooshroomVariant;

class Mooshroom extends Animal
{
    private MooshroomVariant $variant = MooshroomVariant::RED;

    /**
     * @return MooshroomVariant
     */
    public function getVariant(): MooshroomVariant
    {
        return $this->variant;
    }

    /**
     * @param MooshroomVariant $variant
     */
    public function setVariant(MooshroomVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::VAR_INT, $variant);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::MOOSHROOM;
    }
}