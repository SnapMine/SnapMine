<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use Closure;

/**
 * Declares a single named field of a {@see RecordCodec}.
 *
 * Each field couples the encoded key with its {@see Codec} and a way to read
 * the value back off the record instance (for encoding). The decode side is
 * handled by {@see RecordCodec}, reading fields in declaration order and
 * feeding them to the record constructor.
 */
final class Field
{
    public const REQUIRED = 'required';
    public const OPTIONAL = 'optional';
    public const WITH_DEFAULT = 'with_default';

    /**
     * @param Closure(object):mixed $getter
     */
    private function __construct(
        private readonly string $key,
        private readonly string $kind,
        private readonly Codec $codec,
        private readonly mixed $default,
        private readonly Closure $getter
    ) {
    }

    /**
     * The key must be present in the encoded data and be decodable.
     *
     * @param Closure(object):mixed $getter
     */
    public static function required(string $key, Codec $codec, Closure $getter): self
    {
        return new self($key, self::REQUIRED, $codec, null, $getter);
    }

    /**
     * The key may be absent: it then decodes to `null`.
     *
     * @param Closure(object):mixed $getter
     */
    public static function optional(string $key, Codec $codec, Closure $getter): self
    {
        return new self($key, self::OPTIONAL, $codec, null, $getter);
    }

    /**
     * Uses the given default value when the key is absent.
     *
     * @param Closure(object):mixed $getter
     */
    public static function withDefault(string $key, Codec $codec, mixed $default, Closure $getter): self
    {
        return new self($key, self::WITH_DEFAULT, $codec, $default, $getter);
    }

    public function key(): string
    {
        return $this->key;
    }

    /**
     * One of {@see Field::REQUIRED}, {@see Field::OPTIONAL}, {@see Field::WITH_DEFAULT}.
     */
    public function kind(): string
    {
        return $this->kind;
    }

    public function codec(): Codec
    {
        return $this->codec;
    }

    public function default(): mixed
    {
        return $this->default;
    }

    public function get(object $value): mixed
    {
        return ($this->getter)($value);
    }
}