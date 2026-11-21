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
 * @extends RegistryData<PigVariant>
 *
 * @method static PigVariant COLD()
 * @method static PigVariant TEMPERATE()
 * @method static PigVariant WARM()
 */
final class PigVariant extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly string $assetId,
        private readonly array $spawnConditions,
        private readonly ?string $model = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('asset_id', Codecs::string(), fn (self $v) => $v->assetId),
            Field::required('spawn_conditions', Codecs::listOf(SpawnConditions::codec()), fn (self $v) => $v->spawnConditions),
            Field::optional('model', Codecs::string(), fn (self $v) => $v->model),
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

    public function getModel(): ?string
    {
        return $this->model;
    }
}
