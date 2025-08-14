<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Exception\UnimplementException;
use Nirbose\PhpMcServ\World\Position;

abstract class LivingEntity extends Entity
{
    protected int $handStates = 0;
    protected float $health = 1.0;
    protected int $arrowsInBody = 0;
    protected int $beeStringerInBody = 0;
    protected ?Position $bedLocation = null;

    public const HAND_ACTIVE     = 0x01;
    public const HAND_OFF        = 0x02;
    public const HAND_RIPTIDE    = 0x04;

    public function getHandStates(): int
    {
        return $this->handStates;
    }

    public function setHandStates(int $flags): void
    {
        $this->handStates = $flags;
        $this->setMetadata(8, MetadataType::BYTE, $this->handStates);
    }

    public function addHandState(int $flag): void
    {
        $this->handStates |= $flag;
        $this->setMetadata(8, MetadataType::BYTE, $this->handStates);
    }

    public function removeHandState(int $flag): void
    {
        $this->handStates &= ~$flag;
        $this->setMetadata(8, MetadataType::BYTE, $this->handStates);
    }

    public function hasHandState(int $flag): bool
    {
        return ($this->handStates & $flag) !== 0;
    }

    public function setMainHandActive(): void
    {
        $this->addHandState(self::HAND_ACTIVE);
        $this->removeHandState(self::HAND_OFF);
    }

    public function setOffHandActive(): void
    {
        $this->addHandState(self::HAND_ACTIVE | self::HAND_OFF);
    }

    public function clearHandActive(): void
    {
        $this->removeHandState(self::HAND_ACTIVE | self::HAND_OFF | self::HAND_RIPTIDE);
    }

    public function setRiptideSpin(bool $active): void
    {
        if ($active) {
            $this->addHandState(self::HAND_RIPTIDE);
        } else {
            $this->removeHandState(self::HAND_RIPTIDE);
        }
    }

    /**
     * @return float
     */
    public function getHealth(): float
    {
        return $this->health;
    }

    /**
     * @param float $health
     */
    public function setHealth(float $health): void
    {
        $this->health = $health;

        $this->setMetadata(9, MetadataType::FLOAT, $this->health);
    }

    public function getPotionEffects(): array
    {
        throw new UnimplementException();
    }

    public function addPotionEffect(): void
    {
        throw new UnimplementException();
    }

    /**
     * @return int
     */
    public function getArrowsInBody(): int
    {
        return $this->arrowsInBody;
    }

    /**
     * @param int $arrowsInBody
     */
    public function setArrowsInBody(int $arrowsInBody): void
    {
        $this->arrowsInBody = $arrowsInBody;

        $this->setMetadata(12, MetadataType::VAR_INT, $this->arrowsInBody);
    }

    /**
     * @return int
     */
    public function getBeeStringerInBody(): int
    {
        return $this->beeStringerInBody;
    }

    /**
     * @param int $beeStringerInBody
     */
    public function setBeeStringerInBody(int $beeStringerInBody): void
    {
        $this->beeStringerInBody = $beeStringerInBody;

        $this->setMetadata(13, MetadataType::VAR_INT, $this->beeStringerInBody);
    }

    /**
     * @return Position|null
     */
    public function getBedLocation(): ?Position
    {
        return $this->bedLocation;
    }

    /**
     * @param Position|null $bedLocation
     */
    public function setBedLocation(?Position $bedLocation): void
    {
        $this->bedLocation = $bedLocation;

        $this->setMetadata(14, MetadataType::OPTIONAL_POSITION, $this->bedLocation);
    }

    public function isSleeping(): bool
    {
        return !is_null($this->bedLocation);
    }

}