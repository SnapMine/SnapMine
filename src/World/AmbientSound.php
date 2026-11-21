<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * Ambient sound entry shared by `additions_sound` (and any future
 * sound-with-chance block of the biome effects).
 */
final class AmbientSound implements CodecProvider
{
    public function __construct(
        private readonly string $sound,
        private readonly float $tickChance,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('sound', Codecs::string(), fn (self $a) => $a->sound),
            Field::required('tick_chance', Codecs::float(), fn (self $a) => $a->tickChance),
        );
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function getTickChance(): float
    {
        return $this->tickChance;
    }
}
