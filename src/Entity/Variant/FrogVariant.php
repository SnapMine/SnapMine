<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

/**
 * @method static FrogVariant COLD()
 * @method static FrogVariant TEMPERATE()
 * @method static FrogVariant WARM()
 */
class FrogVariant extends RegistryData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'asset_id')]
    private string $assetId = '';

    #[NbtList('spawn_conditions', SpawnConditions::class, true)]
    private array $spawnConditions = [];

    /**
     * @return string
     */
    public function getAssetId(): string
    {
        return $this->assetId;
    }

    /**
     * @return array
     */
    public function getSpawnConditions(): array
    {
        return $this->spawnConditions;
    }
}