<?php

namespace SnapMine\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Argument
{
    public function __construct(
        public ?string $type = null,
    )
    {
    }
}