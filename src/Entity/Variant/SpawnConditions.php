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

    /**
     * @return SpawnCondition|null
     */
    public function getCondition(): ?SpawnCondition
    {
        return $this->condition;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}