<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a string.
 *
 * @implements Codec<string>
 */
final class StringCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $ops->getString($input, $path);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_string($value)) {
            throw CodecException::at(Path::root(), 'expected string, got ' . get_debug_type($value));
        }

        return $ops->createString($value);
    }
}