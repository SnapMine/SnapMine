<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for an array of signed 64-bit integers.
 *
 * @implements Codec<int[]>
 */
final class LongArrayCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getLongArray($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_array($value)) {
            throw CodecException::at(Path::root(), 'expected an array of longs, got ' . get_debug_type($value));
        }

        return $ops->createLongArray($value);
    }
}