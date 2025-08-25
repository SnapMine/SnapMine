<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Ominous;
use SnapMine\Block\Direction;
use SnapMine\Block\VaultState;

class Vault extends BlockData
{
    private VaultState $state = VaultState::INACTIVE;

    use Facing, Ominous;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['vault_state' => $this->state]);
    }

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    /**
     * @param VaultState $state
     */
    public function setState(VaultState $state): void
    {
        $this->state = $state;
    }

    /**
     * @return VaultState
     */
    public function getState(): VaultState
    {
        return $this->state;
    }
}