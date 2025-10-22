<?php

declare(strict_types=1);

namespace SnapMine\Utils;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatValueTag;
use Aternos\Nbt\Tag\IntValueTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

/**
 * Utility class for converting between NBT tags and serializable objects.
 */
final class Nbt
{
    /**
     * Creates an NbtSerializable instance from a CompoundTag.
     *
     * @template T of NbtSerializable
     * @param CompoundTag $tag The NBT compound tag
     * @param class-string<T> $component The target class name
     * @return T The deserialized object
     * @throws \ReflectionException If the class cannot be reflected
     */
    public static function fromNbt(CompoundTag $tag, string $component)
    {
        $reflection = new ReflectionClass($component);
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {
            $value = self::deserializeProperty($property, $tag);

            if ($value !== false) {
                $property->setValue($instance, $value);
            }
        }

        return $instance;
    }

    /**
     * Converts an NbtSerializable instance to a CompoundTag.
     *
     * @param NbtSerializable $component The object to serialize
     * @return CompoundTag The NBT compound tag
     * @throws \ReflectionException If the class cannot be reflected
     */
    public static function toNbt(NbtSerializable $component): CompoundTag
    {
        $compoundTag = new CompoundTag();
        $reflection = new ReflectionClass($component);

        foreach ($reflection->getProperties() as $property) {
            if (! $property->isInitialized($component)) {
                continue;
            }

            $nbtTag = self::serializeProperty($property, $component);

            if ($nbtTag !== null) {
                $tagName = self::getTagName($property);
                $compoundTag[$tagName] = $nbtTag;
            }
        }

        return $compoundTag;
    }

    /**
     * Deserializes a property value from a CompoundTag.
     *
     * @param ReflectionProperty $property The property to deserialize
     * @param CompoundTag $tag The source NBT tag
     * @return mixed The deserialized value or false if no attribute found
     */
    private static function deserializeProperty(ReflectionProperty $property, CompoundTag $tag): mixed
    {
        $attributes = self::getAllNbtAttributes($property);

        if (empty($attributes)) {
            return false;
        }

        $tagName = $attributes[0]['name'] ?? $property->getName();
        $childTag = $tag->get($tagName);

        if ($childTag === null) {
            return null;
        }

        // Try each attribute until one successfully deserializes
        foreach ($attributes as $attribute) {
            $result = self::tryDeserializeWithAttribute($childTag, $attribute, $property);
            if ($result !== false) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Tries to deserialize a tag with a specific attribute.
     *
     * @param mixed $childTag The NBT tag to deserialize
     * @param array<string, mixed> $attribute The attribute metadata
     * @param ReflectionProperty $property The target property
     * @return mixed The deserialized value or false if incompatible
     */
    private static function tryDeserializeWithAttribute(mixed $childTag, array $attribute, ReflectionProperty $property): mixed
    {
        if ($attribute['type'] === 'compound') {
            if (!$childTag instanceof CompoundTag) {
                return false;
            }
            return self::deserializeCompound($childTag, $property);
        }

        if ($attribute['type'] === 'list') {
            if (!$childTag instanceof ListTag) {
                return false;
            }
            return self::deserializeList($childTag, $attribute);
        }

        // For simple tags (StringTag, IntValueTag, etc.)
        $value = self::extractTagValue($childTag);
        if ($value === null) {
            return false;
        }

        return $value;
    }

    /**
     * Deserializes a compound NBT tag to an object.
     *
     * @param mixed $childTag The NBT tag to deserialize
     * @param ReflectionProperty $property The target property
     * @return NbtSerializable|null The deserialized object or null
     * @throws \ReflectionException
     */
    private static function deserializeCompound(mixed $childTag, ReflectionProperty $property): ?NbtSerializable
    {
        if (!$childTag instanceof CompoundTag) {
            return null;
        }

        $type = $property->getType();

        if ($type === null) {
            return null;
        }

        if ($type instanceof ReflectionNamedType) {
            return self::fromNbt($childTag, $type->getName());
        } else {
            return null;
        }
    }

    /**
     * Deserializes a list NBT tag to an array.
     *
     * @param mixed $childTag The NBT tag to deserialize
     * @param array<string, mixed> $attribute The attribute metadata
     * @return array<int, mixed>|null The deserialized array or null
     */
    private static function deserializeList(mixed $childTag, array $attribute): ?array
    {
        if (!$childTag instanceof ListTag) {
            return null;
        }

        $result = [];

        foreach ($childTag as $item) {
            if ($attribute['compound'] && $item instanceof CompoundTag) {
                $result[] = self::fromNbt($item, $attribute['listType']);
            } elseif (method_exists($item, 'getValue')) {
                $result[] = $item->getValue();
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Extracts the value from an NBT tag.
     *
     * @param mixed $tag The NBT tag
     * @return mixed The extracted value or null
     */
    private static function extractTagValue(mixed $tag): mixed
    {
        if ($tag instanceof IntValueTag || $tag instanceof StringTag || $tag instanceof FloatValueTag) {
            return $tag->getValue();
        }

        return null;
    }

    /**
     * Serializes a property value to an NBT tag.
     *
     * @param ReflectionProperty $property The property to serialize
     * @param NbtSerializable $component The source object
     * @return mixed The serialized NBT tag or null
     */
    private static function serializeProperty(ReflectionProperty $property, NbtSerializable $component): mixed
    {
        $value = $property->getValue($component);

        if ($value === null) {
            return null;
        }

        $attributes = self::getAllNbtAttributes($property);

        if (empty($attributes)) {
            return null;
        }

        // Determine which attribute to use based on the value type
        foreach ($attributes as $attribute) {
            if ($attribute['type'] === 'compound' && $value instanceof NbtSerializable) {
                return self::toNbt($value);
            }

            if ($attribute['type'] === 'list' && is_array($value)) {
                return self::serializeList($value, $attribute);
            }

            if ($attribute['type'] !== 'compound' && $attribute['type'] !== 'list' && !is_array($value)) {
                return self::createTag($attribute['type'], $value);
            }
        }

        return null;
    }

    /**
     * Serializes an array to a ListTag.
     *
     * @param array<int, mixed> $value The array to serialize
     * @param array<string, mixed> $attribute The attribute metadata
     * @return ListTag The serialized list tag
     */
    private static function serializeList(array $value, array $attribute): ListTag
    {
        $listTag = new ListTag();

        foreach ($value as $item) {
            if ($attribute['compound'] && $item instanceof NbtSerializable) {
                $listTag[] = self::toNbt($item);
            } else {
                $listTag[] = self::createTag(StringTag::class, (string) $item);
            }
        }

        return $listTag;
    }

    /**
     * Creates an NBT tag with a value.
     *
     * @param class-string $type The tag class name
     * @param mixed $value The value to set
     * @return mixed The created tag
     */
    private static function createTag(string $type, mixed $value): mixed
    {
        $tag = new $type();

        if ($tag instanceof StringTag || $tag instanceof IntValueTag || $tag instanceof FloatValueTag) {
            $tag->setValue(is_bool($value) ? (int)$value : $value);
        }

        return $tag;
    }

    /**
     * Retrieves all NBT attribute metadata from a property.
     *
     * @param ReflectionProperty $property The property to inspect
     * @return array<int, array<string, mixed>> Array of attribute metadata
     */
    public static function getAllNbtAttributes(ReflectionProperty $property): array
    {
        $attributes = [];

        $compoundAttributes = $property->getAttributes(NbtCompound::class);
        foreach ($compoundAttributes as $attr) {
            $attributes[] = self::parseCompoundAttribute($attr->getArguments());
        }

        $listAttributes = $property->getAttributes(NbtList::class);
        foreach ($listAttributes as $attr) {
            $attributes[] = self::parseListAttribute($attr->getArguments());
        }

        $tagAttributes = $property->getAttributes(NbtTag::class);
        foreach ($tagAttributes as $attr) {
            $attributes[] = self::parseTagAttribute($attr->getArguments());
        }

        return $attributes;
    }

    /**
     * Retrieves NBT attribute metadata from a property.
     *
     * @param ReflectionProperty $property The property to inspect
     * @return array<string, mixed>|null The attribute metadata or null
     */
    public static function getNbtAttribute(ReflectionProperty $property): ?array
    {
        $attributes = self::getAllNbtAttributes($property);
        return $attributes[0] ?? null;
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
            'name' => $args[0] ?? null,
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
            'name' => $args[0] ?? null,
            'listType' => $args[1] ?? StringTag::class,
            'compound' => $args[2] ?? false,
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

    /**
     * Gets the NBT tag name for a property.
     *
     * @param ReflectionProperty $property The property
     * @return string The tag name
     */
    private static function getTagName(ReflectionProperty $property): string
    {
        $attribute = self::getNbtAttribute($property);

        return $attribute['name'] ?? $property->getName();
    }
}