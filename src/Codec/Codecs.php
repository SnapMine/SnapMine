<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use Closure;

/**
 * Entry point for building {@see Codec}s.
 *
 * Primitive codecs are immutable and cached as singletons. Combinators build
 * a fresh codec on every call (they carry their own configuration).
 */
final class Codecs
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @return Codec<int>
     */
    public static function int(): Codec
    {
        static $c;

        return $c ??= new IntCodec();
    }

    /**
     * @return Codec<int>
     */
    public static function long(): Codec
    {
        static $c;

        return $c ??= new LongCodec();
    }

    /**
     * @return Codec<float>
     */
    public static function float(): Codec
    {
        static $c;

        return $c ??= new FloatCodec();
    }

    /**
     * @return Codec<float>
     */
    public static function double(): Codec
    {
        static $c;

        return $c ??= new DoubleCodec();
    }

    /**
     * @return Codec<bool>
     */
    public static function bool(): Codec
    {
        static $c;

        return $c ??= new BoolCodec();
    }

    /**
     * @return Codec<string>
     */
    public static function string(): Codec
    {
        static $c;

        return $c ??= new StringCodec();
    }

    /**
     * @return Codec<int[]>
     */
    public static function longArray(): Codec
    {
        static $c;

        return $c ??= new LongArrayCodec();
    }

    /**
     * @template T
     * @param Codec<T> $element
     * @return Codec<list<T>>
     */
    public static function listOf(Codec $element): Codec
    {
        return new ListCodec($element);
    }

    /**
     * @template T
     * @param Codec<T> $value
     * @return Codec<array<string, T>>
     */
    public static function mapOf(Codec $value): Codec
    {
        return new MapCodec($value);
    }

    /**
     * @template T
     * @param Codec<T> $element
     * @param T|null $default
     * @return Codec<T|null>
     */
    public static function optional(Codec $element, mixed $default = null): Codec
    {
        return new OptionalCodec($element, $default);
    }

    /**
     * @template T
     * @template R
     * @param Codec<T> $codec
     * @param Closure(R):T $to       target value -> value understood by the codec
     * @param Closure(T):R $from     value decoded by the codec -> target value
     * @return Codec<R>
     */
    public static function xmap(Codec $codec, Closure $to, Closure $from): Codec
    {
        return new XMapCodec($codec, $to, $from);
    }

    /**
     * @template T of \BackedEnum
     * @param class-string<T> $enum
     * @return Codec<T>
     */
    public static function enum(string $enum): Codec
    {
        return new EnumCodec($enum);
    }

    /**
     * @param Closure():Codec $factory
     * @return Codec<mixed>
     */
    public static function lazy(Closure $factory): Codec
    {
        return new LazyCodec($factory);
    }

    /**
     * Tries each alternative codec in order; the first success wins.
     *
     * @param Codec ...$alternatives
     * @return Codec<mixed>
     */
    public static function either(Codec ...$alternatives): Codec
    {
        return new EitherCodec(...$alternatives);
    }
}