<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use Closure;

/**
 * Converts an existing codec into a codec for another type, via two inverse
 * conversion functions.
 *
 * `$to`   : target value             -> value the underlying codec understands
 * `$from` : value the codec decoded  -> target value
 *
 * @template T
 * @template R
 * @implements Codec<R>
 */
final class XMapCodec implements Codec
{
    /**
     * @param Codec<T> $element
     * @param Closure(R):T $to
     * @param Closure(T):R $from
     */
    public function __construct(
        private readonly Codec $element,
        private readonly Closure $to,
        private readonly Closure $from
    ) {
    }

    /**
     * @return R
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return ($this->from)($this->element->decode($ops, $input, $path));
    }

    /**
     * @param R $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        return $this->element->encode($ops, ($this->to)($value));
    }
}