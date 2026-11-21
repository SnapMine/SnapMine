<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * A single spawn condition of a variant (`spawn_conditions[].condition`).
 *
 * Faithful to the vanilla data: `type` identifies the condition, and the
 * remaining fields depend on it (`biomes`, `structures`, `range`...).
 */
final class SpawnCondition implements CodecProvider
{
    public function __construct(
        private readonly string $type,
        private readonly ?string $biomes = null,
        private readonly ?string $structures = null,
        private readonly ?FloatRange $range = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('type', Codecs::string(), fn (self $c) => $c->type),
            Field::optional('biomes', Codecs::string(), fn (self $c) => $c->biomes),
            Field::optional('structures', Codecs::string(), fn (self $c) => $c->structures),
            Field::optional('range', FloatRange::codec(), fn (self $c) => $c->range),
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getBiomes(): ?string
    {
        return $this->biomes;
    }

    public function getStructures(): ?string
    {
        return $this->structures;
    }

    public function getRange(): ?FloatRange
    {
        return $this->range;
    }
}
