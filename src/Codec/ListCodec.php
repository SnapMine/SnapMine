<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use Closure;

/**
 * Codec for a list of elements, each encoded with the same element codec.
 *
 * @template T
 * @implements Codec<list<T>>
 */
final class ListCodec implements Codec
{
    /**
     * @param Codec<T> $element
     */
    public function __construct(private readonly Codec $element)
    {
    }

    /**
     * @return list<T>
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        $items = $ops->getList($input, $path);

        $result = [];
        foreach ($items as $i => $item) {
            $result[] = $this->element->decode($ops, $item, $path->index($i));
        }

        return $result;
    }

    /**
     * @param list<T> $value
     */
    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!is_array($value)) {
            throw CodecException::at(Path::root(), 'expected a list, got ' . get_debug_type($value));
        }

        $encoded = [];
        foreach ($value as $item) {
            $encoded[] = $this->element->encode($ops, $item);
        }

        return $ops->createList($encoded);
    }
}