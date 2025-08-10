<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Exception;
use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Block\Half;
use Nirbose\PhpMcServ\Block\StairsShape;
use Nirbose\PhpMcServ\Material;

class Stairs implements BlockData
{
    use Facing, Waterlogged;

    private Half $half = Half::BOTTOM;
    private StairsShape $shape = StairsShape::INNER_LEFT;

    public function __construct(
        private readonly Material $material,
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'waterlogged' => $this->waterlogged,
            'facing' => $this->facing->value,
            'shape' => $this->shape->value,
            'half' => $this->half,
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
     * @return Half
     */
    public function getHalf(): Half
    {
        return $this->half;
    }

    /**
     * @param Half $half
     * @throws Exception
     */
    public function setHalf(Half $half): void
    {
        if ($half != Half::BOTTOM && $half != Half::TOP) {
            throw new Exception("Half top or bottom only");
        }

        $this->half = $half;
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