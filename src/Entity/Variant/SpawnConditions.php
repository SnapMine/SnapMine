<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class SpawnConditions implements NbtSerializable
{
    #[NbtList('spawn_conditions', SpawnCondition::class, true)]
    private array $spawn_conditions = [];

    #[NbtTag(IntTag::class, 'priority')]
    private int $priority = 0;

    public function __construct(array $conditions)
    {
        $this->spawn_conditions = $conditions;
    }

    /**
     * @return array
     */
    public function getSpawnConditions(): array
    {
        return $this->spawn_conditions;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}