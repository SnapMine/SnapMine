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
    private ?string $model = null;

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
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @return array
     */
    public function getSpawnConditions(): array
    {
        return $this->spawnConditions;
    }
}