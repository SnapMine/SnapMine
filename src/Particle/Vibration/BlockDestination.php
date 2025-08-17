<?php

namespace Nirbose\PhpMcServ\Particle\Vibration;

use Nirbose\PhpMcServ\Block\Block;

class BlockDestination implements VibrationDestination
{
    public function __construct(
        private Block $block,
    )
    {
    }

    /**
     * @return Block
     */
    public function getBlock(): Block
    {
        return $this->block;
    }
}