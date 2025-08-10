<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Level;
use Nirbose\PhpMcServ\Material;

class Composter implements BlockData
{
    use Level;

    public function getMaterial(): Material
    {
        return Material::COMPOSTER;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return Material::CAULDRON->getBlockId() + $this->level;
    }

    public function getMaximumLevel(): int
    {
        return 8;
    }
}