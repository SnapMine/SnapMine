<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Registry\RegistryData;

/**
 * @extends RegistryData<DimensionType>
 *
 * @method static DimensionType OVERWORLD()
 * @method static DimensionType NETHER()
 * @method static DimensionType THE_END()
 */
final class DimensionType extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly float $ambientLight,
        private readonly bool $bedWorks,
        private readonly float $coordinateScale,
        private readonly string $effects,
        private readonly bool $hasCeiling,
        private readonly bool $hasRaids,
        private readonly bool $hasSkylight,
        private readonly int $height,
        private readonly string $infiniburn,
        private readonly int $logicalHeight,
        private readonly int $minY,
        private readonly int $monsterSpawnBlockLightLimit,
        private readonly bool $natural,
        private readonly bool $piglinSafe,
        private readonly bool $respawnAnchorWorks,
        private readonly bool $ultrawarm,
        private readonly MonsterSpawnLightLevel|int $monsterSpawnLightLevel,
        private readonly ?int $fixedTime = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('ambient_light', Codecs::float(), fn (self $d) => $d->ambientLight),
            Field::required('bed_works', Codecs::bool(), fn (self $d) => $d->bedWorks),
            Field::required('coordinate_scale', Codecs::float(), fn (self $d) => $d->coordinateScale),
            Field::required('effects', Codecs::string(), fn (self $d) => $d->effects),
            Field::required('has_ceiling', Codecs::bool(), fn (self $d) => $d->hasCeiling),
            Field::required('has_raids', Codecs::bool(), fn (self $d) => $d->hasRaids),
            Field::required('has_skylight', Codecs::bool(), fn (self $d) => $d->hasSkylight),
            Field::required('height', Codecs::int(), fn (self $d) => $d->height),
            Field::required('infiniburn', Codecs::string(), fn (self $d) => $d->infiniburn),
            Field::required('logical_height', Codecs::int(), fn (self $d) => $d->logicalHeight),
            Field::required('min_y', Codecs::int(), fn (self $d) => $d->minY),
            Field::required('monster_spawn_block_light_limit', Codecs::int(), fn (self $d) => $d->monsterSpawnBlockLightLimit),
            Field::required('natural', Codecs::bool(), fn (self $d) => $d->natural),
            Field::required('piglin_safe', Codecs::bool(), fn (self $d) => $d->piglinSafe),
            Field::required('respawn_anchor_works', Codecs::bool(), fn (self $d) => $d->respawnAnchorWorks),
            Field::required('ultrawarm', Codecs::bool(), fn (self $d) => $d->ultrawarm),
            Field::required(
                'monster_spawn_light_level',
                Codecs::either(Codecs::int(), MonsterSpawnLightLevel::codec()),
                fn (self $d) => $d->monsterSpawnLightLevel,
            ),
            Field::optional('fixed_time', Codecs::int(), fn (self $d) => $d->fixedTime),
        );
    }

    public function getAmbientLight(): float
    {
        return $this->ambientLight;
    }

    public function isBedWorks(): bool
    {
        return $this->bedWorks;
    }

    public function getCoordinateScale(): float
    {
        return $this->coordinateScale;
    }

    public function getEffects(): string
    {
        return $this->effects;
    }

    public function isHasCeiling(): bool
    {
        return $this->hasCeiling;
    }

    public function isHasRaids(): bool
    {
        return $this->hasRaids;
    }

    public function isHasSkylight(): bool
    {
        return $this->hasSkylight;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getInfiniburn(): string
    {
        return $this->infiniburn;
    }

    public function getLogicalHeight(): int
    {
        return $this->logicalHeight;
    }

    public function getMinY(): int
    {
        return $this->minY;
    }

    public function getMonsterSpawnBlockLightLimit(): int
    {
        return $this->monsterSpawnBlockLightLimit;
    }

    public function isNatural(): bool
    {
        return $this->natural;
    }

    public function isPiglinSafe(): bool
    {
        return $this->piglinSafe;
    }

    public function isRespawnAnchorWorks(): bool
    {
        return $this->respawnAnchorWorks;
    }

    public function isUltrawarm(): bool
    {
        return $this->ultrawarm;
    }

    public function getMonsterSpawnLightLevel(): MonsterSpawnLightLevel|int
    {
        return $this->monsterSpawnLightLevel;
    }

    public function getFixedTime(): ?int
    {
        return $this->fixedTime;
    }
}
