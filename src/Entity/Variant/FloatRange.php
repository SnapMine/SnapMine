<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * A `min`/`max` float range used by conditions such as
 * `minecraft:moon_brightness`.
 */
final class FloatRange implements CodecProvider
{
    public function __construct(
        private readonly ?float $min = null,
        private readonly ?float $max = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::optional('min', Codecs::float(), fn (self $r) => $r->min),
            Field::optional('max', Codecs::float(), fn (self $r) => $r->max),
        );
    }

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }
}
