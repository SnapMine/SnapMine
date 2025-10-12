<?php

namespace SnapMine\Nbt;

use Aternos\Nbt\Tag\Tag;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NbtTag
{
    /**
     * @template T of Tag
     *
     * @param class-string<T> $type
     * @param ?string $name
     */
    public function __construct(string $type, ?string $name = null)
    {
    }
}