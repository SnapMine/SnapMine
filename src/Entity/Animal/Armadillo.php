<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\Animal\Animal;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;

class Armadillo extends Animal
{
    private ArmadilloState $state = ArmadilloState::IDLE;

    /**
     * @return ArmadilloState
     */
    public function getState(): ArmadilloState
    {
        return $this->state;
    }

    /**
     * @param ArmadilloState $bit
     */
    public function setState(ArmadilloState $bit): void
    {
        $this->state = $bit;

        $this->setMetadata(17, MetadataType::ARMADILLO_STATE, $this->state->value);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::ARMADILLO;
    }
}