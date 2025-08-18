<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Tilt;
use Nirbose\PhpMcServ\Material;

class BigDripleaf extends BigDripleafStem
{
    private Tilt $tilt = Tilt::NONE;

    public function getMaterial(): Material
    {
        return Material::BIG_DRIPLEAF;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'facing' => $this->facing,
            'waterlogged' => $this->waterlogged,
        ]);
    }

    /**
     * @param Tilt $tilt
     */
    public function setTilt(Tilt $tilt): void
    {
        $this->tilt = $tilt;
    }

    /**
     * @return Tilt
     */
    public function getTilt(): Tilt
    {
        return $this->tilt;
    }
}