<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;

class Turtle extends Animal
{
    private bool $hasEgg = false;
    private bool $layingEgg = false;

    /**
     * @return bool
     */
    public function hasEgg(): bool
    {
        return $this->hasEgg;
    }

    /**
     * @param bool $hasEgg
     */
    public function setHasEgg(bool $hasEgg): void
    {
        $this->hasEgg = $hasEgg;

        $this->setMetadata(17, MetadataType::BOOLEAN, $this->hasEgg);
    }

    /**
     * @return bool
     */
    public function isLayingEgg(): bool
    {
        return $this->layingEgg;
    }

    /**
     * @param bool $layingEgg
     */
    public function setLayingEgg(bool $layingEgg): void
    {
        $this->layingEgg = $layingEgg;

        $this->setMetadata(18, MetadataType::BOOLEAN, $this->layingEgg);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::TURTLE;
    }
}