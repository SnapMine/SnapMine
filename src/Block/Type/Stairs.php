<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Stairs implements BlockData
{
    use Facing, Waterlogged;

    private string $half = 'bottom';
    private string $shape = 'inner_left';

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
            'shape' => $this->shape,
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
     * @return string
     */
    public function getHalf(): string
    {
        return $this->half;
    }

    /**
     * @param string $half
     */
    public function setHalf(string $half): void
    {
        $this->half = $half;
    }

    /**
     * @return string
     */
    public function getShape(): string
    {
        return $this->shape;
    }

    /**
     * @param string $shape
     */
    public function setShape(string $shape): void
    {
        $this->shape = $shape;
    }
}