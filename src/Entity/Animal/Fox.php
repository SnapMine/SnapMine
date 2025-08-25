<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Entity\Player;
use SnapMine\Entity\Variant\FoxVariant;
use SnapMine\Exception\UnimplementException;

class Fox extends Animal
{
    private FoxVariant $variant = FoxVariant::RED;
    private int $state = 0;

    public function isSitting(): bool
    {
        return (bool) (($this->state >> 0x01) & 1);
    }

    public function setSitting(bool $sitting): void
    {
        $this->setState(0x01, $sitting);
    }

    public function isCrouching(): bool
    {
        return (bool) (($this->state >> 0x04) & 1);
    }

    public function setCrouching(bool $crouching): void
    {
        $this->setState(0x04, $crouching);
    }

    public function isInterested(): bool
    {
        return (bool) (($this->state >> 0x08) & 1);
    }

    public function setInterested(bool $interested): void
    {
        $this->setState(0x08, $interested);
    }

    public function isPouncing(): bool
    {
        return (bool) (($this->state >> 0x10) & 1);
    }

    public function setPouncing(bool $pouncing): void
    {
        $this->setState(0x10, $pouncing);
    }

    public function isSleeping(): bool
    {
        return (bool) (($this->state >> 0x20) & 1);
    }

    public function setSleeping(bool $sleeping): void
    {
        $this->setState(0x20, $sleeping);
    }

    public function isFaceplanted(): bool
    {
        return (bool) (($this->state >> 0x40) & 1);
    }

    public function setFaceplanted(bool $faceplanted): void
    {
        $this->setState(0x40, $faceplanted);
    }

    public function isDefending(): bool
    {
        return (bool) (($this->state >> 0x80) & 1);
    }

    public function setDefending(bool $defending): void
    {
        $this->setState(0x80, $defending);
    }

    /**
     * @param int $bit
     * @param bool $set
     */
    public function setState(int $bit, bool $set): void
    {
        if ($set) {
            $this->state |= $bit;
        } else {
            $this->state &= ~$bit;
        }

        $this->setMetadata(18, MetadataType::BYTE, $this->state);
    }

    /**
     * @return FoxVariant
     */
    public function getVariant(): FoxVariant
    {
        return $this->variant;
    }

    /**
     * @param FoxVariant $variant
     */
    public function setVariant(FoxVariant $variant): void
    {
        $this->variant = $variant;

        $this->setMetadata(17, MetadataType::VAR_INT, $this->state);
    }

    public function getFirstTrustedPlayer(): ?Player
    {
        throw new UnimplementException();
    }

    public function setFirstTrustedPlayer(?Player $player): void
    {
        throw new UnimplementException();
    }

    public function getSecondTrustedPlayer(): ?Player
    {
        throw new UnimplementException();
    }

    public function setSecondTrustedPlayer(?Player $player): void
    {
        throw new UnimplementException();
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::FOX;
    }
}