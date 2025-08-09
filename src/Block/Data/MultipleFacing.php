<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\Direction;

interface MultipleFacing
{
    /**
     * @return Direction[]
     */
    public function getAllowedFaces(): array;

    /**
     * @return Direction[]
     */
    public function getFaces(): array;

    public function setFace(Direction $face): void;

    public function hasFace(Direction $face): bool;
}