<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

class GenericSnowy implements BlockData
{
    private bool $isSnowy = false;

    public function __construct(
        private readonly Material $material,
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'snowy' => $this->isSnowy,
        ]);
    }

    /**
     * @return bool
     */
    public function isSnowy(): bool
    {
        return $this->isSnowy;
    }

    /**
     * @param bool $isSnowy
     */
    public function setIsSnowy(bool $isSnowy): void
    {
        $this->isSnowy = $isSnowy;
    }
}