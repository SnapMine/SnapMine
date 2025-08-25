<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Power;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\SensorPhase;

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