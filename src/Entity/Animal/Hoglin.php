<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;

class Hoglin extends Animal
{
    private bool $immune = false;

    /**
     * @return bool
     */
    public function isImmune(): bool
    {
        return $this->immune;
    }

    /**
     * @param bool $immune
     */
    public function setImmune(bool $immune): void
    {
        $this->immune = $immune;

        $this->setMetadata(17, MetadataType::BOOLEAN, $immune);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::HOGLIN;
    }
}