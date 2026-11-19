<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Bidirectional serializer/deserializer for tree-shaped formats (NBT, JSON).
 *
 * A single declaration describes how to both decode a value from a tree and
 * encode it back. The representation of the tree is abstracted behind {@see Ops},
 * which lets the same codec work against NBT tags, JSON arrays, or any other
 * future format.
 *
 * @template T
 */
interface Codec
{
    /**
     * Decode a value from an encoded tree node.
     *
     * @param Ops $ops   the format adapter used to inspect the tree
     * @param mixed $input the encoded node (a map, list, scalar, ...)
     * @param Path $path  current location in the tree, used to build precise errors
     * @return T
     * @throws CodecException when the node cannot be decoded
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed;

    /**
     * Encode a value into a tree node.
     *
     * @param Ops $ops the format adapter used to build the tree
     * @param T $value the value to encode
     * @return mixed the encoded node
     * @throws CodecException when the value cannot be encoded
     */
    public function encode(Ops $ops, mixed $value): mixed;
}