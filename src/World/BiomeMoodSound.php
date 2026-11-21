<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class BiomeMoodSound implements CodecProvider
{
    public function __construct(
        private readonly int $blockSearchExtent,
        private readonly float $offset,
        private readonly string $sound,
        private readonly int $tickDelay,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('block_search_extent', Codecs::int(), fn (self $m) => $m->blockSearchExtent),
            Field::required('offset', Codecs::double(), fn (self $m) => $m->offset),
            Field::required('sound', Codecs::string(), fn (self $m) => $m->sound),
            Field::required('tick_delay', Codecs::int(), fn (self $m) => $m->tickDelay),
        );
    }

    public function getBlockSearchExtent(): int
    {
        return $this->blockSearchExtent;
    }

    public function getOffset(): float
    {
        return $this->offset;
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function getTickDelay(): int
    {
        return $this->tickDelay;
    }
}
