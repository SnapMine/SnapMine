<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\Entity\SnifferState;

class Sniffer extends Animal
{
    private SnifferState $state = SnifferState::IDLING;
    private int $dropSeedTick = 0;

    /**
     * @return SnifferState
     */
    public function getState(): SnifferState
    {
        return $this->state;
    }

    /**
     * @param SnifferState $bit
     */
    public function setState(SnifferState $bit): void
    {
        $this->state = $bit;

        $this->setMetadata(17, MetadataType::SNIFFER_STATE, $bit);
    }

    /**
     * @return int
     */
    public function getDropSeedTick(): int
    {
        return $this->dropSeedTick;
    }

    /**
     * @param int $dropSeedTick
     */
    public function setDropSeedTick(int $dropSeedTick): void
    {
        $this->dropSeedTick = $dropSeedTick;

        $this->setMetadata(18, MetadataType::VAR_INT, $dropSeedTick);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::SNIFFER;
    }
}