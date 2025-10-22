<?php

declare(strict_types=1);

namespace SnapMine\Utils;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;
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
     * Converts an NbtSerializable instance to a JSON array.
     *
     * @param NbtSerializable $instance The object to convert
     * @return array<string, mixed> The JSON data as an associative array
     * @throws \ReflectionException If the class cannot be reflected
     */
    public static function toJson(NbtSerializable $instance): array
    {
        $reflection = new ReflectionClass($instance);
        $result = [];

        foreach ($reflection->getProperties() as $property) {
            $value = self::getPropertyValue($instance, $property);

            if ($value !== null) {
                $attribute = Nbt::getNbtAttribute($property);
                $propertyName = $attribute['name'] ?? $property->getName();
                $result[$propertyName] = $value;
            }
        }

        return $result;
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
        // Get the first attribute's name for the JSON key
        $attribute = Nbt::getNbtAttribute($property);
        $propertyName = $attribute['name'] ?? $property->getName();

        if (!array_key_exists($propertyName, $json)) {
            return;
        }

        $value = $json[$propertyName];

        // Get all attributes to handle multi-type
        $attributes = Nbt::getAllNbtAttributes($property);

        if (!empty($attributes)) {
            $value = self::processValueWithAttributes($value, $attributes, $property);
        }

        $property->setValue($instance, $value);
    }

    /**
     * Processes a value with multiple attributes (multi-type support).
     *
     * @param mixed $value The value to process
     * @param array<int, array<string, mixed>> $attributes All attributes
     * @param ReflectionProperty $property The property reflection
     * @return mixed The processed value
     */
    private static function processValueWithAttributes(
        mixed $value,
        array $attributes,
        ReflectionProperty $property
    ): mixed {
        // Try each attribute based on the value type
        foreach ($attributes as $attribute) {
            if ($attribute['type'] === 'compound' && is_array($value) && self::isAssociativeArray($value)) {
                return self::processCompound($value, $property);
            }

            if ($attribute['type'] === 'list' && is_array($value)) {
                return self::processList($value, $attribute);
            }

            // For simple types (string, int, float, etc.)
            if ($attribute['type'] !== 'compound' && $attribute['type'] !== 'list' && !is_array($value)) {
                return $value;
            }
        }

        return $value;
    }

    /**
     * Gets a property value for JSON export.
     *
     * @param object $instance The object instance
     * @param ReflectionProperty $property The property to get
     * @return mixed The property value or null
     */
    private static function getPropertyValue(
        object $instance,
        ReflectionProperty $property
    ): mixed {
        $value = $property->getValue($instance);

        if ($value === null) {
            return null;
        }

        // Handle NbtSerializable objects
        if ($value instanceof NbtSerializable) {
            return self::toJson($value);
        }

        // Handle arrays
        if (is_array($value)) {
            return self::processArrayForJson($value);
        }

        return $value;
    }

    /**
     * Processes an array for JSON export.
     *
     * @param array<int|string, mixed> $array The array to process
     * @return array<int|string, mixed> The processed array
     */
    private static function processArrayForJson(array $array): array
    {
        $result = [];

        foreach ($array as $key => $item) {
            if ($item instanceof NbtSerializable) {
                $result[$key] = self::toJson($item);
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
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

        $type = $property->getType();

        if ($type instanceof ReflectionUnionType) {
            // Find the first class type in the union
            $classTypes = array_filter(
                $type->getTypes(),
                fn (ReflectionType $t) => !$t->isBuiltin() && class_exists($t->getName())
            );

            if (empty($classTypes)) {
                return $value;
            }

            $class = reset($classTypes)->getName();
        } else {
            $class = $type instanceof ReflectionNamedType ? $type->getName() : null;
        }

        return ($class !== null && class_exists($class)) ? self::fromJson($value, $class) : $value;
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
            $result[] = ($elementClass !== null && is_array($item) && self::isAssociativeArray($item))
                ? self::fromJson($item, $elementClass)
                : $item;
        }

        return $result;
    }

    /**
     * Checks if an array is associative.
     *
     * @param array<mixed, mixed> $array The array to check
     * @return bool True if associative, false otherwise
     */
    private static function isAssociativeArray(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}