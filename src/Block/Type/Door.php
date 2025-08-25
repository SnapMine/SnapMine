<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Half;
use SnapMine\Block\Data\Openable;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Door extends BlockData
{
    use Facing, Half, Openable, Powerable;
    private string $hinge = 'left';


    public function computedId(array $data = []): int
    {
        return parent::computedId(['hinge' => $this->hinge]);
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
     * @param string $hinge
     */
    public function setHinge(string $hinge): void
    {
        $this->hinge = $hinge;
    }

    /**
     * @return string
     */
    public function getHinge(): string
    {
        return $this->hinge;
    }
}