<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Direction;

class Beehive extends BlockData
{
    private int $honeyLevel = 0;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['honey_level' => $this->honeyLevel]);
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
     * @param int $honeyLevel
     */
    public function setHoneyLevel(int $honeyLevel): void
    {
        $this->honeyLevel = $honeyLevel;
    }

    /**
     * @return int
     */
    public function getHoneyLevel(): int
    {
        return $this->honeyLevel;
    }
}