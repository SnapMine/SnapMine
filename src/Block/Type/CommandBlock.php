<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class CommandBlock extends BlockData
{
    private bool $conditional = false;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['conditional' => $this->conditional]);
    }

    public function getFaces(): array
    {
        return Direction::cases();
    }

    /**
     * @param bool $conditional
     */
    public function setConditional(bool $conditional): void
    {
        $this->conditional = $conditional;
    }

    /**
     * @return bool
     */
    public function isConditional(): bool
    {
        return $this->conditional;
    }
}