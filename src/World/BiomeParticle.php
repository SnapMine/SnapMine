<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * A biome particle entry (`effects.particle`): `options` + `probability`.
 */
final class BiomeParticle implements CodecProvider
{
    public function __construct(
        private readonly ParticleOptions $options,
        private readonly float $probability,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('options', ParticleOptions::codec(), fn (self $p) => $p->options),
            Field::required('probability', Codecs::float(), fn (self $p) => $p->probability),
        );
    }

    public function getOptions(): ParticleOptions
    {
        return $this->options;
    }

    public function getProbability(): float
    {
        return $this->probability;
    }
}
