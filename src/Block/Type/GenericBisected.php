<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

class GenericBisected implements BlockData
{
    private string $half = 'lower';

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
            'half' => $this->half,
        ]);
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
    public function getHalf(): string
    {
        return $this->half;
    }
}