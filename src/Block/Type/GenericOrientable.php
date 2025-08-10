<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Axis;
use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

class GenericOrientable implements BlockData
{
    private Axis $axis = Axis::X;

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
        return $loader->getBlockStateId($this->material, [
            'axis' => $this->axis->value,
        ]);
    }

    /**
     * @param Axis $axis
     */
    public function setAxis(Axis $axis): void
    {
        $this->axis = $axis;
    }

    /**
     * @return Axis
     */
    public function getAxis(): Axis
    {
        return $this->axis;
    }
}