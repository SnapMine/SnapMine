<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\CreakingHeartState;
use Nirbose\PhpMcServ\Block\Data\Axis;
use Nirbose\PhpMcServ\Block\Data\BlockData;

class CreakingHeart extends BlockData
{
    protected bool $natural = false;
    protected CreakingHeartState $state = CreakingHeartState::AWAKE;

    use Axis;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['natural' => $this->natural, 'creaking_heart_state' => $this->state]);
    }

    /**
     * @param bool $natural
     */
    public function setNatural(bool $natural): void
    {
        $this->natural = $natural;
    }

    /**
     * @return bool
     */
    public function isNatural(): bool
    {
        return $this->natural;
    }

    /**
     * @param CreakingHeartState $state
     */
    public function setState(CreakingHeartState $state): void
    {
        $this->state = $state;
    }

    /**
     * @return CreakingHeartState
     */
    public function getState(): CreakingHeartState
    {
        return $this->state;
    }
}