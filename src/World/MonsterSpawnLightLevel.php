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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getMaxInclusive(): int
    {
        return $this->maxInclusive;
    }

    public function setMaxInclusive(int $maxInclusive): void
    {
        $this->maxInclusive = $maxInclusive;
    }

    public function getMinInclusive(): int
    {
        return $this->minInclusive;
    }

    public function setMinInclusive(int $minInclusive): void
    {
        $this->minInclusive = $minInclusive;
    }
}