<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class Music implements CodecProvider
{
    public function __construct(
        private readonly MusicData $data,
        private readonly int $weight,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('data', MusicData::codec(), fn (self $m) => $m->data),
            Field::required('weight', Codecs::int(), fn (self $m) => $m->weight),
        );
    }

    public function getData(): MusicData
    {
        return $this->data;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}
