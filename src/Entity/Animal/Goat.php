<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;

class Goat extends Animal
{
    private bool $isScreaming = false;
    private bool $hasLeftHorn = true;
    private bool $hasRightHorn = true;

    /**
     * @return bool
     */
    public function isScreaming(): bool
    {
        return $this->isScreaming;
    }

    /**
     * @param bool $isScreaming
     */
    public function setIsScreaming(bool $isScreaming): void
    {
        $this->isScreaming = $isScreaming;

        $this->setMetadata(17, MetadataType::BOOLEAN, $this->isScreaming);
    }

    /**
     * @return bool
     */
    public function hasLeftHorn(): bool
    {
        return $this->hasLeftHorn;
    }

    /**
     * @param bool $hasLeftHorn
     */
    public function setLeftHorn(bool $hasLeftHorn): void
    {
        $this->hasLeftHorn = $hasLeftHorn;

        $this->setMetadata(18, MetadataType::BOOLEAN, $this->hasLeftHorn);
    }

    /**
     * @return bool
     */
    public function hasRightHorn(): bool
    {
        return $this->hasRightHorn;
    }

    /**
     * @param bool $hasRightHorn
     */
    public function setRightHorn(bool $hasRightHorn): void
    {
        $this->hasRightHorn = $hasRightHorn;

        $this->setMetadata(19, MetadataType::BOOLEAN, $this->hasRightHorn);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::GOAT;
    }
}