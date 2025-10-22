<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\IntTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class SpawnConditions implements NbtSerializable
{
    #[NbtCompound('condition')]
    private ?SpawnCondition $condition = null;

    #[NbtTag(IntTag::class)]
    private int $priority;
}