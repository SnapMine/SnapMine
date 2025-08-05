<?php

namespace Nirbose\PhpMcServ\Entity;

class EvokerFangs extends Entity
{

    /**
     * @inheritDoc
     */
    function getType(): EntityType
    {
        return EntityType::EVOKER_FANGS;
    }
}