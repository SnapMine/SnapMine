<?php

namespace Nirbose\PhpMcServ\Entity;

class DragonFireball extends Entity
{

    /**
     * @inheritDoc
     */
    function getType(): EntityType
    {
        return EntityType::DRAGON_FIREBALL;
    }
}