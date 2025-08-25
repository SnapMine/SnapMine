<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Half;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;
use SnapMine\Block\StairsShape;

class Stairs extends BlockData
{
    use Facing, Half, Waterlogged;
    private StairsShape $shape = StairsShape::INNER_LEFT;


   public function computedId(array $data = []): int
   {
       return parent::computedId(['shape' => $this->shape]);
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
     * @return StairsShape
     */
    public function getShape(): StairsShape
    {
        return $this->shape;
    }

    /**
     * @param StairsShape $shape
     */
    public function setShape(StairsShape $shape): void
    {
        $this->shape = $shape;
    }
}