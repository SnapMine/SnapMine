<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a 64-bit IEEE-754 double precision float.
 *
 * @implements Codec<float>
 */
final class DoubleCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getDouble($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_float($value)) {
            throw CodecException::at(Path::root(), 'expected double, got ' . get_debug_type($value));
        }

        return $ops->createDouble($value);
    }
}