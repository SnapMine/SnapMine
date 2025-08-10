<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Material;

class Slab implements Waterlogged
{
    private bool $waterlogged = false;

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
        ]);
    }

    public function isWaterlogged(): bool
    {
        return $this->waterlogged;
    }

    public function setWaterlogged(bool $waterlogged): void
    {
        $this->waterlogged = $waterlogged;
    }
}