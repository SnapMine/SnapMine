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
 * @extends RegistryData<FrogVariant>
 *
 * @method static FrogVariant COLD()
 * @method static FrogVariant TEMPERATE()
 * @method static FrogVariant WARM()
 */
final class FrogVariant extends RegistryData implements CodecProvider
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
