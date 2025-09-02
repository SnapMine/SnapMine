<?php

namespace SnapMine\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Command
{
    public function __construct(
        public string $name,
        public ?string $methodName = null
    )
    {
    }
}