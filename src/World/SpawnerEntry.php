<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * A mob spawner entry of a biome (`spawners.<category>[n]`).
 */
final class SpawnerEntry implements CodecProvider
{
    public function __construct(
        private readonly string $type,
        private readonly int $weight,
        private readonly int $minCount,
        private readonly int $maxCount,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('type', Codecs::string(), fn (self $s) => $s->type),
            Field::required('weight', Codecs::int(), fn (self $s) => $s->weight),
            Field::required('minCount', Codecs::int(), fn (self $s) => $s->minCount),
            Field::required('maxCount', Codecs::int(), fn (self $s) => $s->maxCount),
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getMinCount(): int
    {
        return $this->minCount;
    }

    public function getMaxCount(): int
    {
        return $this->maxCount;
    }
}
