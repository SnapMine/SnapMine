<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use BackedEnum;
use ValueError;

/**
 * Codec for PHP backed enums, serialized as their string value.
 *
 * @template T of BackedEnum
 * @implements Codec<T>
 */
final class EnumCodec implements Codec
{
    /**
     * @param class-string<T> $enum
     */
    public function __construct(private readonly string $enum)
    {
        if (!is_subclass_of($enum, BackedEnum::class)) {
            throw new \InvalidArgumentException($enum . ' is not a backed enum');
        }
    }

    /**
     * @return T
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        $value = $ops->getString($input, $path);

        try {
            return ($this->enum)::from($value);
        } catch (ValueError $e) {
            $className = $this->enum;

            throw CodecException::at(
                $path,
                "'{$value}' is not a valid {$className} value",
                $e
            );
        }
    }

    /**
     * @param T $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!($value instanceof $this->enum)) {
            throw CodecException::at(
                Path::root(),
                'expected an instance of ' . $this->enum . ', got ' . get_debug_type($value)
            );
        }

        if (!is_string($value->value)) {
            throw CodecException::at(Path::root(), 'expected a string backed enum');
        }

        return $ops->createString($value->value);
    }
}