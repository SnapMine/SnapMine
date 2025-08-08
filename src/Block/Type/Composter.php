<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Level;
use Nirbose\PhpMcServ\Material;

class Composter implements Level
{
    private int $level = 0;

    public function getMaterial(): Material
    {
        return Material::COMPOSTER;
    }

    public function computedId(): int
    {
        return Material::CAULDRON->getBlockId() + get_block_state_offset([$this->level], [1]);
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