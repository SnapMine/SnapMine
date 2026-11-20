<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * {@see Ops} adapter for JSON-like data (decoded PHP arrays/scalars).
 *
 * Maps are associative arrays, lists are list arrays, and the primitives are
 * the native PHP scalars. The "empty" marker is `null`.
 */
final class JsonOps implements Ops
{
    private function __construct()
    {
    }

    public static function get(): self
    {
        static $ops;

        return $ops ??= new self();
    }

    public function getInt(mixed $input, Path $path): int
    {
        if (!is_int($input)) {
            throw CodecException::at($path, 'expected an integer, got ' . get_debug_type($input));
        }

        return $input;
    }

    public function getLong(mixed $input, Path $path): int
    {
        return $this->getInt($input, $path);
    }

    public function getFloat(mixed $input, Path $path): float
    {
        if (!is_int($input) && !is_float($input)) {
            throw CodecException::at($path, 'expected a float, got ' . get_debug_type($input));
        }

        return (float) $input;
    }

    public function getDouble(mixed $input, Path $path): float
    {
        return $this->getFloat($input, $path);
    }

    public function getBool(mixed $input, Path $path): bool
    {
        if (!is_bool($input)) {
            throw CodecException::at($path, 'expected a boolean, got ' . get_debug_type($input));
        }

        return $input;
    }

    public function getString(mixed $input, Path $path): string
    {
        if (!is_string($input)) {
            throw CodecException::at($path, 'expected a string, got ' . get_debug_type($input));
        }

        return $input;
    }

    public function getLongArray(mixed $input, Path $path): array
    {
        if (!is_array($input) || !array_is_list($input)) {
            throw CodecException::at($path, 'expected an array of longs, got ' . get_debug_type($input));
        }

        foreach ($input as $i => $item) {
            if (!is_int($item)) {
                throw CodecException::at($path->index($i), 'expected an integer, got ' . get_debug_type($item));
            }
        }

        /** @var int[] $input */
        return $input;
    }

    public function createInt(int $value): mixed
    {
        return $value;
    }

    public function createLong(int $value): mixed
    {
        return $value;
    }

    public function createFloat(float $value): mixed
    {
        return $value;
    }

    public function createDouble(float $value): mixed
    {
        return $value;
    }

    public function createBool(bool $value): mixed
    {
        return $value;
    }

    public function createString(string $value): mixed
    {
        return $value;
    }

    public function createLongArray(array $value): mixed
    {
        return $value;
    }

    public function getMap(mixed $input, Path $path): array
    {
        if (!is_array($input) || (array_is_list($input) && $input !== [])) {
            throw CodecException::at($path, 'expected a map (object), got ' . get_debug_type($input));
        }

        /** @var array<string, mixed> $input */
        return $input;
    }

    public function getList(mixed $input, Path $path): array
    {
        if (!is_array($input) || !array_is_list($input)) {
            throw CodecException::at($path, 'expected a list (array), got ' . get_debug_type($input));
        }

        /** @var list<mixed> $input */
        return $input;
    }

    public function createMap(array $map): mixed
    {
        return $map;
    }

    public function createList(array $list): mixed
    {
        return $list;
    }

    public function isEmpty(mixed $input): bool
    {
        return $input === null;
    }

    public function empty(): mixed
    {
        return null;
    }
}
