<?php

namespace SnapMine\Block\Type;

use InvalidArgumentException;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Repeater extends BlockData
{
    private int $delay = 1;
    private bool $locked = false;

    use Facing, Powerable;

    public function computedId(array $data = []): int
    {
        return parent::computedId([
            'delay' => $this->delay,
            'locked' => $this->locked,
        ]);
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
     * @param int $delay
     */
    public function setDelay(int $delay): void
    {
        if ($delay > 4 || $delay < 0) {
            throw new InvalidArgumentException('Delay must be between 0 and 4.');
        }

        $this->delay = $delay;
    }

    /**
     * @return int
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @param bool $locked
     */
    public function setLocked(bool $locked): void
    {
        $this->locked = $locked;
    }
}