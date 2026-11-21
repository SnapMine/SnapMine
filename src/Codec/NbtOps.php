<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\FloatValueTag;
use Aternos\Nbt\Tag\DoubleTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\IntValueTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\LongArrayTag;
use Aternos\Nbt\Tag\LongTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;

/**
 * {@see Ops} implementation over the {@see Aternos\Nbt} tag model.
 *
 * Map nodes are {@see CompoundTag}s, list nodes are {@see ListTag}s and each
 * primitive is mapped onto its dedicated tag type (int => IntTag, long =>
 * LongTag, float => FloatTag, ...).
 */
final class NbtOps implements Ops
{
    public function __construct(private readonly bool $longAsInt = true)
    {
    }

    /**
     * Shared default instance.
     */
    public static function get(): self
    {
        static $ops;

        return $ops ??= new self();
    }

    /*
     * ---- reading primitives --------------------------------------------------
     */

    public function getInt(mixed $input, Path $path): int
    {
        return $this->requireValueTag($input, $path)->getValue();
    }

    public function getLong(mixed $input, Path $path): int
    {
        if ($input instanceof LongTag) {
            return $input->getValue();
        }

        $this->expect($input, $path);
        if (!$input instanceof IntValueTag) {
            throw CodecException::at($path, 'expected a long tag');
        }

        return $input->getValue();
    }

    public function getFloat(mixed $input, Path $path): float
    {
        $this->expect($input, $path);

        return $this->readFloatValue($input, $path);
    }

    public function getDouble(mixed $input, Path $path): float
    {
        $this->expect($input, $path);

        return $this->readFloatValue($input, $path);
    }

    public function getBool(mixed $input, Path $path): bool
    {
        $this->expect($input, $path);
        if (!$input instanceof IntValueTag) {
            throw CodecException::at($path, 'expected a boolean (byte 0/1) tag');
        }

        return $input->getValue() !== 0;
    }

    public function getString(mixed $input, Path $path): string
    {
        $this->expect($input, $path);
        if (!$input instanceof StringTag) {
            throw CodecException::at($path, 'expected a string tag');
        }

        return $input->getValue();
    }

    public function getLongArray(mixed $input, Path $path): array
    {
        $this->expect($input, $path);
        if (!$input instanceof LongArrayTag) {
            throw CodecException::at($path, 'expected a long array tag');
        }

        $values = [];
        foreach ($input as $value) {
            $values[] = $value;
        }

        return $values;
    }

    /*
     * ---- writing primitives --------------------------------------------------
     */

    public function createInt(int $value): mixed
    {
        return (new IntTag())->setValue($value);
    }

    public function createLong(int $value): mixed
    {
        return (new LongTag())->setValue($value);
    }

    public function createFloat(float $value): mixed
    {
        return (new FloatTag())->setValue($value);
    }

    public function createDouble(float $value): mixed
    {
        return (new DoubleTag())->setValue($value);
    }

    public function createBool(bool $value): mixed
    {
        return (new ByteTag())->setValue((int) $value);
    }

    public function createString(string $value): mixed
    {
        return (new StringTag())->setValue($value);
    }

    public function createLongArray(array $value): mixed
    {
        $tag = new LongArrayTag();
        $i = 0;
        foreach ($value as $item) {
            $tag[$i++] = $item;
        }

        return $tag;
    }

    /*
     * ---- structures ----------------------------------------------------------
     */

    public function getMap(mixed $input, Path $path): array
    {
        $this->expect($input, $path);
        if (!$input instanceof CompoundTag) {
            throw CodecException::at($path, 'expected a compound tag');
        }

        $map = [];
        foreach ($input as $key => $child) {
            $map[$key] = $child;
        }

        return $map;
    }

    public function getList(mixed $input, Path $path): array
    {
        $this->expect($input, $path);
        if (!$input instanceof ListTag) {
            throw CodecException::at($path, 'expected a list tag');
        }

        $list = [];
        foreach ($input as $child) {
            $list[] = $child;
        }

        return $list;
    }

    public function createMap(array $map): mixed
    {
        $tag = new CompoundTag();
        foreach ($map as $key => $child) {
            $tag->set((string) $key, $child);
        }

        return $tag;
    }

    public function createList(array $list): mixed
    {
        $tag = new ListTag();
        $i = 0;
        foreach ($list as $child) {
            $tag[$i++] = $child;
        }

        return $tag;
    }

    /*
     * ---- optional / empty ----------------------------------------------------
     */

    public function isEmpty(mixed $input): bool
    {
        return $input instanceof CompoundTag && count($input) === 0;
    }

    public function empty(): mixed
    {
        return new CompoundTag();
    }

    /*
     * ---- helpers -------------------------------------------------------------
     */

    private function readFloatValue(mixed $input, Path $path): float
    {
        if ($input instanceof FloatValueTag) {
            return $input->getValue();
        }

        throw CodecException::at($path, 'expected a floating point tag');
    }

    private function expect(mixed $input, Path $path): void
    {
        if (!$input instanceof Tag) {
            throw CodecException::at($path, 'expected an NBT tag');
        }
    }

    private function requireValueTag(mixed $input, Path $path): IntValueTag
    {
        $this->expect($input, $path);
        if (!$input instanceof IntValueTag) {
            throw CodecException::at($path, 'expected an integer tag');
        }

        return $input;
    }
}