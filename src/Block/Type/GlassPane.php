<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class GlassPane implements BlockData
{
    use MultipleFacing, Waterlogged;

    public function __construct(
        private readonly Material $material,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getAllowedFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'waterlogged' => $this->waterlogged,
            'east' => $this->hasFace(Direction::EAST),
            'west' => $this->hasFace(Direction::WEST),
            'north' => $this->hasFace(Direction::NORTH),
            'south' => $this->hasFace(Direction::SOUTH),
        ]);
    }
}