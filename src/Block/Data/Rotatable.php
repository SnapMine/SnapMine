<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Rotatable
{
    protected int $rotation = 0;

    public function getRotation(): int
    {
        return $this->rotation;
    }
    public function setRotation(int $rotation): void
    {
        $this->rotation = $rotation;
    }
}