<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class WolfAssets implements CodecProvider
{
    public function __construct(
        private readonly string $angry,
        private readonly string $tame,
        private readonly string $wild,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('angry', Codecs::string(), fn (self $a) => $a->angry),
            Field::required('tame', Codecs::string(), fn (self $a) => $a->tame),
            Field::required('wild', Codecs::string(), fn (self $a) => $a->wild),
        );
    }

    public function getAngry(): string
    {
        return $this->angry;
    }

    public function getTame(): string
    {
        return $this->tame;
    }

    public function getWild(): string
    {
        return $this->wild;
    }
}
