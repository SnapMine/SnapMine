<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a boolean.
 *
 * In NBT booleans are stored as a byte tag holding `0` or `1`.
 *
 * @implements Codec<bool>
 */
final class BoolCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getBool($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_bool($value)) {
            throw CodecException::at(Path::root(), 'expected boolean, got ' . get_debug_type($value));
        }

        return $ops->createBool($value);
    }
}