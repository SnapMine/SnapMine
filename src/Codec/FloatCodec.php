<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a 32-bit IEEE-754 single precision float.
 *
 * @implements Codec<float>
 */
final class FloatCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getFloat($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_float($value)) {
            throw CodecException::at(Path::root(), 'expected float, got ' . get_debug_type($value));
        }

        return $ops->createFloat($value);
    }
}