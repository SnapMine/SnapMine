<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;

class Panda extends Animal
{
    private int $breedTimer = 0;
    private int $sneezeTimer = 0;
    private int $eatTimer = 0;
    private int $mainGene = 0;
    private int $hiddenGene = 0;
    private int $state = 0;

    /**
     * @return int
     */
    public function getBreedTimer(): int
    {
        return $this->breedTimer;
    }

    /**
     * @param int $breedTimer
     */
    public function setBreedTimer(int $breedTimer): void
    {
        $this->breedTimer = $breedTimer;

        $this->setMetadata(17, MetadataType::VAR_INT, $this->breedTimer);
    }

    /**
     * @return int
     */
    public function getSneezeTimer(): int
    {
        return $this->sneezeTimer;
    }

    /**
     * @param int $sneezeTimer
     */
    public function setSneezeTimer(int $sneezeTimer): void
    {
        $this->sneezeTimer = $sneezeTimer;

        $this->setMetadata(18, MetadataType::VAR_INT, $this->sneezeTimer);
    }

    /**
     * @return int
     */
    public function getEatTimer(): int
    {
        return $this->eatTimer;
    }

    /**
     * @param int $eatTimer
     */
    public function setEatTimer(int $eatTimer): void
    {
        $this->eatTimer = $eatTimer;

        $this->setMetadata(19, MetadataType::VAR_INT, $this->eatTimer);
    }

    /**
     * @return int
     */
    public function getMainGene(): int
    {
        return $this->mainGene;
    }

    /**
     * @param int $mainGene
     */
    public function setMainGene(int $mainGene): void
    {
        $this->mainGene = $mainGene;

        $this->setMetadata(20, MetadataType::BYTE, $this->mainGene);
    }

    /**
     * @return int
     */
    public function getHiddenGene(): int
    {
        return $this->hiddenGene;
    }

    /**
     * @param int $hiddenGene
     */
    public function setHiddenGene(int $hiddenGene): void
    {
        $this->hiddenGene = $hiddenGene;

        $this->setMetadata(21, MetadataType::BYTE, $this->hiddenGene);
    }

    public function isSneezing(): bool
    {
        return (bool) ($this->state >> 0x02) & 1;
    }

    public function setSneezing(bool $val): void
    {
        $this->setState(0x02, $val);
    }

    public function isRolling(): bool
    {
        return (bool) ($this->state >> 0x04) & 1;
    }

    public function setRolling(bool $val): void
    {
        $this->setState(0x04, $val);
    }

    public function isSitting(): bool
    {
        return (bool) ($this->state >> 0x08) & 1;
    }

    public function setSitting(bool $val): void
    {
        $this->setState(0x08, $val);
    }

    public function isOnBack(): bool
    {
        return (bool) ($this->state >> 0x10) & 1;
    }

    public function setOnBack(bool $val): void
    {
        $this->setState(0x10, $val);
    }

    private function setState(int $bit, bool $val): void
    {
        if ($val) {
            $this->state |= $bit;
        } else {
            $this->state &= ~$bit;
        }

        $this->setMetadata(22, MetadataType::BYTE, $this->state);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::PANDA;
    }
}