<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

class Cake implements BlockData
{
    private int $bits = 6;

    public function getMaterial(): Material
    {
        return Material::CAKE;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $this->getMaterial()->getBlockId() + $this->bits;
    }

    /**
     * @param int $bits
     */
    public function setBits(int $bits): void
    {
        $this->bits = $bits;
    }

    /**
     * @return int
     */
    public function getBits(): int
    {
        return $this->bits;
    }
}