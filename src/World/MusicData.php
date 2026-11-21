<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class MusicData implements CodecProvider
{
    public function __construct(
        private readonly int $maxDelay,
        private readonly int $minDelay,
        private readonly bool $replaceCurrentMusic,
        private readonly string $sound,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('max_delay', Codecs::int(), fn (self $d) => $d->maxDelay),
            Field::required('min_delay', Codecs::int(), fn (self $d) => $d->minDelay),
            Field::required('replace_current_music', Codecs::bool(), fn (self $d) => $d->replaceCurrentMusic),
            Field::required('sound', Codecs::string(), fn (self $d) => $d->sound),
        );
    }

    public function getMaxDelay(): int
    {
        return $this->maxDelay;
    }

    public function getMinDelay(): int
    {
        return $this->minDelay;
    }

    public function isReplaceCurrentMusic(): bool
    {
        return $this->replaceCurrentMusic;
    }

    public function getSound(): string
    {
        return $this->sound;
    }
}
