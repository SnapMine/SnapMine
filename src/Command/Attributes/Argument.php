<?php

namespace SnapMine\Command\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Argument
{
    private array $arguments = [];

    public function __construct(mixed ...$arguments)
    {
        foreach ($arguments as $argument) {
            $this->arguments[] = $argument;
        }
    }
}