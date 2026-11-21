<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a 32-bit integer.
 *
 * @implements Codec<int>
 */
final class IntCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getInt($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_int($value)) {
            throw CodecException::at(Path::root(), 'expected integer, got ' . get_debug_type($value));
        }

        return $ops->createInt($value);
    }
}