<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\Attached;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\MultipleFacing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Tripwire extends BlockData
{
    private bool $disarmed = false;

    use Attached, Powerable, MultipleFacing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['disarmed' => $this->disarmed]);
    }

    public function getAllowedFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    /**
     * @param bool $disarmed
     */
    public function setDisarmed(bool $disarmed): void
    {
        $this->disarmed = $disarmed;
    }

    /**
     * @return bool
     */
    public function isDisarmed(): bool
    {
        return $this->disarmed;
    }
}