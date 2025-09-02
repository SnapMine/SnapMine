<?php

namespace SnapMine\Command\Attributes;

use Attribute;
use SnapMine\Artisan;

#[Attribute(Attribute::TARGET_CLASS)]
class Command
{

    public function __construct(
        public string $name,
    )
    {
    }
}