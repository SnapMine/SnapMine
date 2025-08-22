<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Tilt;

class BigDripleaf extends BigDripleafStem
{
    private Tilt $tilt = Tilt::NONE;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['tilt' => $this->tilt]);
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