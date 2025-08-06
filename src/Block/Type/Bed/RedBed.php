<?php

namespace Nirbose\PhpMcServ\Block\Type\Bed;


use Nirbose\PhpMcServ\Material;

class RedBed extends Bed {
    public function __construct()
    {
        parent::__construct(Material::RED_BED);
    }
}

