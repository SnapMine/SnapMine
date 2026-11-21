<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a signed 64-bit integer.
 *
 * @implements Codec<int>
 */
final class LongCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getLong($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_int($value)) {
            throw CodecException::at(Path::root(), 'expected long, got ' . get_debug_type($value));
        }

        return $ops->createLong($value);
    }
}