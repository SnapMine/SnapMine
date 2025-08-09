<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

readonly class GenericBlockData implements BlockData
{
    public function __construct(
        private Material $material,
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(): int
    {
        return $this->material->getBlockId();
    }
}