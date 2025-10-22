<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

/**
 * @method static ChickenVariant COLD()
 * @method static ChickenVariant TEMPERATE()
 * @method static ChickenVariant WARM()
 */
class ChickenVariant extends RegistryData implements NbtSerializable
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