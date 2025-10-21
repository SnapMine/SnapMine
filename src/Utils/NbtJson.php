<?php

declare(strict_types=1);

namespace SnapMine\Utils;

use ReflectionClass;
use ReflectionProperty;
use SnapMine\NbtSerializable;

/**
 * Utility class for converting JSON arrays to NBT serializable objects.
 */
final class NbtJson
{
    /**
     * Creates an NbtSerializable instance from a JSON array.
     *
     * @template T of NbtSerializable
     * @param array<string, mixed> $json The JSON data as an associative array
     * @param class-string<T> $class The target class name
     * @return T The instantiated object
     * @throws \ReflectionException If the class cannot be reflected
     */
    public static function fromJson(array $json, string $class)
    {
        $reflection = new ReflectionClass($class);
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {
            self::setPropertyValue($instance, $property, $json);
        }

        return $instance;
    }

    /**
     * Sets a property value from JSON data.
     *
     * @param object $instance The object instance
     * @param ReflectionProperty $property The property to set
     * @param array<string, mixed> $json The JSON data
     */
    private static function setPropertyValue(
        object $instance,
        ReflectionProperty $property,
        array $json
    ): void {
        $attribute = Nbt::getNbtAttribute($property);
        $propertyName = $attribute['name'] ?? $property->getName();

        if (!array_key_exists($propertyName, $json)) {
            return;
        }

        $value = $json[$propertyName];

        if ($attribute === null) {
            $property->setValue($instance, $value);
            return;
        }

        $processedValue = match ($attribute['type']) {
            'compound' => self::processCompound($value, $property),
            'list' => self::processList($value, $attribute),
            default => $value
        };

        $property->setValue($instance, $processedValue);
    }

    /**
     * Processes a compound NBT value (nested object).
     *
     * @param mixed $value The value to process
     * @param ReflectionProperty $property The property reflection
     * @return mixed The processed value
     */
    private static function processCompound(mixed $value, ReflectionProperty $property): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        $type = $property->getType()?->getName();

        var_dump($value);
        return $type !== null ? self::fromJson($value, $type) : $value;
    }

    /**
     * Processes a list NBT value (array).
     *
     * @param mixed $value The value to process
     * @param array<string, mixed> $attribute The attribute metadata
     * @return mixed The processed value
     */
    private static function processList(mixed $value, array $attribute): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        $elementClass = $attribute['compound'] ? $attribute['listType'] : null;
        $result = [];

        foreach ($value as $item) {
            $result[] = ($elementClass !== null && is_array($item))
                ? self::fromJson($item, $elementClass)
                : $item;
        }

        return $result;
    }

    /**
     * Parses NbtCompound attribute arguments.
     *
     * @param array<string|int, mixed> $args The attribute arguments
     * @return array<string, mixed> The parsed attribute data
     */
    private static function parseCompoundAttribute(array $args): array
    {
        return [
            'type' => 'compound',
            'name' => $args['name'] ?? $args[0] ?? null,
        ];
    }

    /**
     * Parses NbtList attribute arguments.
     *
     * @param array<string|int, mixed> $args The attribute arguments
     * @return array<string, mixed> The parsed attribute data
     */
    private static function parseListAttribute(array $args): array
    {
        return [
            'type' => 'list',
            'name' => $args['name'] ?? $args[0] ?? null,
            'listType' => $args['type'] ?? null,
            'compound' => $args['compound'] ?? false,
        ];
    }

    /**
     * Parses NbtTag attribute arguments.
     *
     * @param array<string|int, mixed> $args The attribute arguments
     * @return array<string, mixed> The parsed attribute data
     */
    private static function parseTagAttribute(array $args): array
    {
        return [
            'type' => $args[0] ?? null,
            'name' => $args[1] ?? null,
        ];
    }
}