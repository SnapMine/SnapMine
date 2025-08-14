<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Exception\UnimplementException;

abstract class LivingEntity extends Entity
{
    protected float $health = 1.0;
    protected int $arrowsInBody = 0;
    protected int $beeStringerInBody = 0;

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

}