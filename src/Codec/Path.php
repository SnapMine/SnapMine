<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Immutable location inside an encoded tree.
 *
 * Paths are built progressively while traversing the tree and are used to
 * produce precise, human readable error messages such as:
 *
 *     sections[3].block_states.palette[2].Name: missing
 *
 * Keys are separated by `.` and list indices are written as `[n]`.
 */
final class Path
{
    private function __construct(private readonly string $path)
    {
    }

    /**
     * The empty path, pointing at the root of the tree.
     */
    public static function root(): self
    {
        return new self('');
    }

    /**
     * A path built directly from a preformatted string.
     */
    public static function of(string $path): self
    {
        return new self($path);
    }

    /**
     * Descend into the named key of a map node.
     */
    public function child(string $key): self
    {
        $path = $this->path === '' ? $key : $this->path . '.' . $key;

        return new self($path);
    }

    /**
     * Descend into the n-th element of a list node.
     */
    public function index(int $i): self
    {
        $path = $this->path === '' ? "[$i]" : $this->path . "[$i]";

        return new self($path);
    }

    /**
     * Whether this path points at the root of the tree.
     */
    public function isRoot(): bool
    {
        return $this->path === '';
    }

    /**
     * The formatted string representation of the path.
     */
    public function toString(): string
    {
        return $this->path;
    }

    public function __toString(): string
    {
        return $this->path === '' ? '(root)' : $this->path;
    }
}