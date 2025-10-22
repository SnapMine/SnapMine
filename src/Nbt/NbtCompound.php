<?php

namespace SnapMine\Nbt;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NbtCompound
{
    public function __construct(
        public string $name
    ) {}
}