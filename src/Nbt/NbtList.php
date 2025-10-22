<?php

namespace SnapMine\Nbt;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NbtList
{
    public function __construct(
        public string $name,
        public string $type,
        public bool $compound = false
    ) {}
}