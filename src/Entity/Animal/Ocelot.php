<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;

class Ocelot extends Animal
{
    private bool $trusting = false;

    /**
     * @return bool
     */
    public function isTrusting(): bool
    {
        return $this->trusting;
    }

    /**
     * @param bool $trusting
     */
    public function setTrusting(bool $trusting): void
    {
        $this->trusting = $trusting;

        $this->setMetadata(17, MetadataType::BOOLEAN, $this->trusting);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::OCELOT;
    }
}