<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Direction;

class EndPortalFrame extends BlockData
{
    private bool $eye = false;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['eye' => $this->eye]);
    }

    /**
     * @param bool $eye
     */
    public function setEye(bool $eye): void
    {
        $this->eye = $eye;
    }

    /**
     * @return bool
     */
    public function hasEye(): bool
    {
        return $this->eye;
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
}