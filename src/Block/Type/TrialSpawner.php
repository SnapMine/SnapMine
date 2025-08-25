<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Ominous;
use SnapMine\Block\TrialSpawnerState;

class TrialSpawner extends BlockData
{
    private TrialSpawnerState $state = TrialSpawnerState::INACTIVE;

    use Ominous;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['trial_spawner_state' => $this->state]);
    }

    /**
     * @param TrialSpawnerState $state
     */
    public function setState(TrialSpawnerState $state): void
    {
        $this->state = $state;
    }

    /**
     * @return TrialSpawnerState
     */
    public function getState(): TrialSpawnerState
    {
        return $this->state;
    }
}