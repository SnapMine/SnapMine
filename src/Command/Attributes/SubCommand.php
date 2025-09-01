<?php

namespace SnapMine\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class SubCommand
{
    public function __construct(
        public string $name = '',
    )
    {
    }
}