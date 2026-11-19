<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Format adapter between {@see Codec}s and a concrete tree-shaped data model.
 *
 * The encoded node type is left generic (`mixed`): for NBT it is an
 * {@see \Aternos\Nbt\Tag\Tag}, for JSON it is an array or scalar. A codec only
 * talks to {@see Ops}, which means the very same declarations work unchanged
 * across every supported format.
 *
 * All reading methods throw a {@see CodecException} carrying the supplied path
 * when the node does not have the expected shape.
 */
interface Ops
{
    /*
     * ---- reading primitives --------------------------------------------------
     */

    public function getInt(mixed $input, Path $path): int;

    public function getLong(mixed $input, Path $path): int;

    public function getFloat(mixed $input, Path $path): float;

    public function getDouble(mixed $input, Path $path): float;

    public function getBool(mixed $input, Path $path): bool;

    public function getString(mixed $input, Path $path): string;

    /** @return int[] */
    public function getLongArray(mixed $input, Path $path): array;

    /*
     * ---- writing primitives --------------------------------------------------
     */

    public function createInt(int $value): mixed;

    public function createLong(int $value): mixed;

    public function createFloat(float $value): mixed;

    public function createDouble(float $value): mixed;

    public function createBool(bool $value): mixed;

    public function createString(string $value): mixed;

    /** @param int[] $value */
    public function createLongArray(array $value): mixed;

    /*
     * ---- structures ----------------------------------------------------------
     */

    /**
     * Read a map node as an associative array of `key => node`.
     *
     * @return array<string, mixed>
     */
    public function getMap(mixed $input, Path $path): array;

    /**
     * Read a list node as a list of child nodes.
     *
     * @return list<mixed>
     */
    public function getList(mixed $input, Path $path): array;

    /**
     * Build a map node from `key => node` pairs.
     *
     * @param array<string, mixed> $map
     */
    public function createMap(array $map): mixed;

    /**
     * Build a list node from child nodes.
     *
     * @param list<mixed> $list
     */
    public function createList(array $list): mixed;

    /*
     * ---- optional / empty ----------------------------------------------------
     */

    /**
     * Whether the node should be treated as "empty" (i.e. an absent value).
     *
     * Used by {@see OptionalCodec} both to decode a missing value back to
     * `null` and to encode `null` into a marker node.
     */
    public function isEmpty(mixed $input): bool;

    /**
     * An empty marker node, the counterpart of {@see isEmpty()}.
     */
    public function empty(): mixed;
}