<?php

namespace SnapMine\Block\Type;

use InvalidArgumentException;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;
use SnapMine\Block\Thickness;

class PointedDripstone extends BlockData
{
    private Thickness $thickness = Thickness::BASE;
    private Direction $verticalDirection = Direction::UP;

    use Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['thickness' => $this->thickness, 'vertical_direction' => $this->verticalDirection]);
    }

    /**
     * @param Direction $verticalDirection
     */
    public function setVerticalDirection(Direction $verticalDirection): void
    {
        if ($verticalDirection != Direction::UP && $verticalDirection != Direction::DOWN) {
            throw new InvalidArgumentException('The vertical direction must be up or down');
        }

        $this->verticalDirection = $verticalDirection;
    }

    /**
     * @return Thickness
     */
    public function getThickness(): Thickness
    {
        return $this->thickness;
    }

    /**
     * @return Direction
     */
    public function getVerticalDirection(): Direction
    {
        return $this->verticalDirection;
    }

    /**
     * @param Thickness $thickness
     */
    public function setThickness(Thickness $thickness): void
    {
        $this->thickness = $thickness;
    }
}