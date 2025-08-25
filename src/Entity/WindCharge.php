<?php

namespace SnapMine\Entity;

class WindCharge extends Entity
{

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::WIND_CHARGE;
    }
}