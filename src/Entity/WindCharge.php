<?php

namespace Nirbose\PhpMcServ\Entity;

class WindCharge extends Entity
{

    /**
     * @inheritDoc
     */
    function getType(): EntityType
    {
        return EntityType::WIND_CHARGE;
    }
}