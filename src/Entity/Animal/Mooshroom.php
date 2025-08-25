<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Entity\Variant\MooshroomVariant;

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