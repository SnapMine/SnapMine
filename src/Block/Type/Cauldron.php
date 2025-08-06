<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Level;
use Nirbose\PhpMcServ\Material;

class Cauldron implements Level
{
    private int $level = 0;

    public function getMaterial(): Material
    {
        return Material::CAULDRON;
    }

    public function computedId(): int
    {
        return Material::CAULDRON->getBlockId() + get_block_state_offset([$this->level], [1]);
    }

    public function getMaximumLevel(): int
    {
        return 3;
    }

    public function setLevel(int $level): void
    {
        if ($level < 0 || $level > $this->getMaximumLevel()) {
            // TODO: Throw error
        }

        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
}