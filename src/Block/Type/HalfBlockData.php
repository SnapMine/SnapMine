<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Half;
use Nirbose\PhpMcServ\Material;

class HalfBlockData implements BlockData
{
    use Half;

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
}