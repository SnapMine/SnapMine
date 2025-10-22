<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class MonsterSpawnLightLevel implements NbtSerializable
{
    #[NbtTag(StringTag::class)]
    private string $type;

    #[NbtTag(IntTag::class, 'max_inclusive')]
    private int $maxInclusive;

    #[NbtTag(IntTag::class, 'min_inclusive')]
    private int $minInclusive;
}