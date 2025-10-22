<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

/**
 * @extends RegistryData<CatVariant>
 *
 * @method static CatVariant ALL_BLACK()
 * @method static CatVariant BLACK()
 * @method static CatVariant BRITISH_SHORTHAIR()
 * @method static CatVariant CALICO()
 * @method static CatVariant JELLIE()
 * @method static CatVariant PERSIAN()
 * @method static CatVariant RAGDOLL()
 * @method static CatVariant RED()
 * @method static CatVariant SIAMESE()
 * @method static CatVariant TABBY()
 * @method static CatVariant WHITE()
 */
class CatVariant extends RegistryData implements NbtSerializable
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