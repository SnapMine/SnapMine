<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Codec for a nullable value.
 *
 * An absent/empty node decodes to the default value (usually `null`) and a
 * value equal to the default encodes back to an empty node.
 *
 * @template T
 * @implements Codec<T|null>
 */
final class OptionalCodec implements Codec
{
    /**
     * @param Codec<T> $element
     * @param T|null $default
     */
    public function __construct(
        private readonly Codec $element,
        private readonly mixed $default = null
    ) {
    }

    /**
     * @return T|null
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        if ($ops->isEmpty($input)) {
            return $this->default;
        }

        return $this->element->decode($ops, $input, $path);
    }

    /**
     * @param T|null $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if ($value === $this->default) {
            return $ops->empty();
        }

        return $this->element->encode($ops, $value);
    }
}