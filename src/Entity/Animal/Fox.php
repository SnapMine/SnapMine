<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Entity\Variant\FoxVariant;
use Nirbose\PhpMcServ\Exception\UnimplementException;

class Fox extends Animal
{
    private FoxVariant $variant = FoxVariant::RED;
    private int $state = 0;

    public function isSitting(): bool
    {
        return $this->state & 0x01;
    }

    public function setSitting(bool $sitting): void
    {
        $this->setState(0x01, $sitting);
    }

    public function isCrouching(): bool
    {
        return $this->state & 0x04;
    }

    public function setCrouching(bool $crouching): void
    {
        $this->setState(0x04, $crouching);
    }

    public function isInterested(): bool
    {
        return $this->state & 0x08;
    }

    public function setInterested(bool $interested): void
    {
        $this->setState(0x08, $interested);
    }

    public function isPouncing(): bool
    {
        return $this->state & 0x10;
    }

    public function setPouncing(bool $pouncing): void
    {
        $this->setState(0x10, $pouncing);
    }

    public function isSleeping(): bool
    {
        return $this->state & 0x20;
    }

    public function setSleeping(bool $sleeping): void
    {
        $this->setState(0x20, $sleeping);
    }

    public function isFaceplanted(): bool
    {
        return $this->state & 0x40;
    }

    public function setFaceplanted(bool $faceplanted): void
    {
        $this->setState(0x40, $faceplanted);
    }

    public function isDefending(): bool
    {
        return $this->state & 0x80;
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