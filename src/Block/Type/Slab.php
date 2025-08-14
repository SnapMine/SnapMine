<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Type;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Material;

class Slab implements BlockData
{
    use Waterlogged, Type;

    public function __construct(
        private readonly Material $material,
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    /**
     * @throws \Exception
     */
    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'waterlogged' => $this->waterlogged,
            'type' => $this->type,
        ]);
    }
}