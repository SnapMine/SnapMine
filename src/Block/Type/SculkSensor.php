<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Power;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\SensorPhase;

class SculkSensor extends BlockData
{
    private SensorPhase $phase = SensorPhase::INACTIVE;

    use Power, Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['sculk_sensor_phase' => $this->phase]);
    }

    /**
     * @param SensorPhase $phase
     */
    public function setPhase(SensorPhase $phase): void
    {
        $this->phase = $phase;
    }

    /**
     * @return SensorPhase
     */
    public function getPhase(): SensorPhase
    {
        return $this->phase;
    }
}