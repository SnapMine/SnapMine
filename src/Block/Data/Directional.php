<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Directional extends BlockData
{
    public function getFaces(): array;
}