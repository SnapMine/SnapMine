<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Rotatable
{
    public function getRotation(): int;
    public function setRotation(int $rotation): void;
}