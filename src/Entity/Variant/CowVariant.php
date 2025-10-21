<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

/**
 * @method static CowVariant COLD()
 * @method static CowVariant TEMPERATE()
 * @method static CowVariant WARM()
 */
class CowVariant extends RegistryData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'asset_id')]
    private string $assetId;

    #[NbtTag(StringTag::class)]
    private string $model;

    #[NbtList('spawn_conditions', SpawnCondition::class, true)]
    private array $spawnConditions = [];
}