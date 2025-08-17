<?php

namespace Nirbose\PhpMcServ\Particle\Vibration;

class VibrationParticle
{
    public function __construct(
        private VibrationDestination $destination,
        private int $arrivalTicks,
    )
    {
    }

    /**
     * @return int
     */
    public function getArrivalTicks(): int
    {
        return $this->arrivalTicks;
    }

    /**
     * @return VibrationDestination
     */
    public function getDestination(): VibrationDestination
    {
        return $this->destination;
    }
}