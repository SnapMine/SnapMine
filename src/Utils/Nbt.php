<?php

declare(strict_types=1);

namespace SnapMine\Utils;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatValueTag;
use Aternos\Nbt\Tag\IntValueTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use ReflectionClass;
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
        $attribute = self::getNbtAttribute($property);

        if ($attribute === null) {
            return false;
        }

        $tagName = $attribute['name'] ?? $property->getName();
        $childTag = $tag->get($tagName);

        if ($childTag === null) {
            return null;
        }

        if ($attribute['type'] === 'compound') {
            return self::deserializeCompound($childTag, $property);
        }

        if ($attribute['type'] === 'list') {
            return self::deserializeList($childTag, $attribute);
        }

        return self::extractTagValue($childTag);
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

        return self::fromNbt($childTag, $type->getName());
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
        $attribute = self::getNbtAttribute($property);

        if ($attribute === null) {
            return null;
        }

        $value = $property->getValue($component);

        if ($value === null) {
            return null;
        }

        return match ($attribute['type']) {
            'compound' => self::toNbt($value),
            'list' => self::serializeList($value, $attribute),
            default => self::createTag($attribute['type'], $value),
        };
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
     * Retrieves NBT attribute metadata from a property.
     *
     * @param ReflectionProperty $property The property to inspect
     * @return array<string, mixed>|null The attribute metadata or null
     */
    public static function getNbtAttribute(ReflectionProperty $property): ?array
    {
        $compoundAttributes = $property->getAttributes(NbtCompound::class);
        if (!empty($compoundAttributes)) {
            return self::parseCompoundAttribute($compoundAttributes[0]->getArguments());
        }

        $listAttributes = $property->getAttributes(NbtList::class);
        if (!empty($listAttributes)) {
            return self::parseListAttribute($listAttributes[0]->getArguments());
        }

        $tagAttributes = $property->getAttributes(NbtTag::class);
        if (!empty($tagAttributes)) {
            return self::parseTagAttribute($tagAttributes[0]->getArguments());
        }

        return null;
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