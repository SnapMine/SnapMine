<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a map (strings to values), each value encoded with the same codec.
 *
 * @template T
 * @implements Codec<array<string, T>>
 */
final class MapCodec implements Codec
{
    /**
     * @param Codec<T> $value
     */
    public function __construct(private readonly Codec $value)
    {
    }

    /**
     * @return array<string, T>
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        $map = $ops->getMap($input, $path);

        $result = [];
        foreach ($map as $key => $node) {
            $result[$key] = $this->value->decode($ops, $node, $path->child($key));
        }

        return $result;
    }

    /**
     * @param array<string, T> $value
     */
    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_array($value)) {
            throw CodecException::at(Path::root(), 'expected a map, got ' . get_debug_type($value));
        }

        $encoded = [];
        foreach ($value as $key => $item) {
            $encoded[(string) $key] = $this->value->encode($ops, $item);
        }

        return $ops->createMap($encoded);
    }
}