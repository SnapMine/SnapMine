<?php

declare(strict_types=1);

namespace SnapMine\Codec\Io;

use SnapMine\Codec\Codec;
use SnapMine\Codec\JsonOps;
use SnapMine\Codec\Path;

/**
 * Facade to decode/encode plain PHP data (e.g. `json_decode(..., true)`)
 * through a {@see Codec}.
 */
final class JsonIO
{
    /**
     * @template T
     * @param Codec<T> $codec
     * @return T
     */
    public static function decode(Codec $codec, mixed $data): mixed
    {
        return $codec->decode(JsonOps::get(), $data, Path::root());
    }

    /**
     * @template T
     * @param Codec<T> $codec
     * @param T $value
     */
    public static function encode(Codec $codec, mixed $value): mixed
    {
        return $codec->encode(JsonOps::get(), $value);
    }
}
