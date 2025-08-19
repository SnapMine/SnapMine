<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Age;

class CaveVines extends CaveVinesPlant
{
    use Age;

    public function getMaximumAge(): int
    {
        return 25;
    }
}