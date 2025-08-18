<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\RailShape;
use Nirbose\PhpMcServ\Material;

class Rail implements BlockData
{
    protected RailShape $shape = RailShape::ASCENDING_EAST;

    use Waterlogged;

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
            'shape' => $this->shape,
        ]);
    }

    /**
     * @param RailShape $shape
     */
    public function setShape(RailShape $shape): void
    {
        $this->shape = $shape;
    }

    /**
     * @return RailShape
     */
    public function getShape(): RailShape
    {
        return $this->shape;
    }
}