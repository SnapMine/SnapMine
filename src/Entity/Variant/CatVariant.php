<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
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
final class CatVariant extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly string $assetId,
        private readonly array $spawnConditions,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('asset_id', Codecs::string(), fn (self $v) => $v->assetId),
            Field::required('spawn_conditions', Codecs::listOf(SpawnConditions::codec()), fn (self $v) => $v->spawnConditions),
        );
    }

    public function getAssetId(): string
    {
        return $this->assetId;
    }

    /**
     * @return SpawnConditions[]
     */
    public function getSpawnConditions(): array
    {
        return $this->spawnConditions;
    }
}
