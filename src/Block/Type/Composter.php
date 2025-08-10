<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Level;
use Nirbose\PhpMcServ\Material;

class Composter implements Level
{
    private int $level = 0;

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

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
}