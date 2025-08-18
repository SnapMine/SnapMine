<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\HalfType;
use Nirbose\PhpMcServ\Material;

class GenericBisected implements BlockData
{
    private HalfType $half = HalfType::LOWER;

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
     * @param HalfType $half
     */
    public function setHalf(HalfType $half): void
    {
        $this->half = $half;
    }

    /**
     * @return HalfType
     */
    public function getHalf(): HalfType
    {
        return $this->half;
    }
}