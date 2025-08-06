<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\Direction;

interface Directional extends BlockData
{

    /**
     * @return Direction[]
     */
    public function getFaces(): array;

    public function getFacing(): Direction;
}