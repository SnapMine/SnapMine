<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use SnapMine\Keyed;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\EncodableToNbt;
use SnapMine\Registry\RegistryData;
use RuntimeException;

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

    #[NbtCompound('spawn_conditions')]
    private SpawnConditions $spawnConditions;

    /**
     * @return string
     */
    public function getAssetId(): string
    {
        return $this->assetId;
    }

    /**
     * @return SpawnConditions
     */
    public function getSpawnConditions(): SpawnConditions
    {
        return $this->spawnConditions;
    }
}