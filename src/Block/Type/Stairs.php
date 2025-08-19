<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Half;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Block\StairsShape;

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