<?php

namespace Nirbose\PhpMcServ\Entity;

class EvokerFangs extends Entity
{

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::EVOKER_FANGS;
    }
}