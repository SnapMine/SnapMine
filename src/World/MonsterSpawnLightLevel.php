<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class MonsterSpawnLightLevel implements CodecProvider
{
    public function __construct(
        private readonly string $type,
        private readonly int $maxInclusive,
        private readonly int $minInclusive,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('type', Codecs::string(), fn (self $m) => $m->type),
            Field::required('max_inclusive', Codecs::int(), fn (self $m) => $m->maxInclusive),
            Field::required('min_inclusive', Codecs::int(), fn (self $m) => $m->minInclusive),
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMaxInclusive(): int
    {
        return $this->maxInclusive;
    }

    public function getMinInclusive(): int
    {
        return $this->minInclusive;
    }
}
