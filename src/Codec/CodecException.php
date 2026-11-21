<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use RuntimeException;

/**
 * Thrown whenever a {@see Codec} fails to decode or encode a value.
 *
 * The exception carries the {@see Path} where the failure happened so that
 * tools and logs can point precisely at the offending node
 * (e.g. `sections[3].block_states.palette[2].Name: missing`).
 */
final class CodecException extends RuntimeException
{
    private function __construct(
        private readonly Path $path,
        string $message,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    /**
     * Build an exception for a given location.
     */
    public static function at(Path $path, string $message, ?\Throwable $previous = null): self
    {
        return new self($path, $path . ': ' . $message, $previous);
    }

    /**
     * Location in the tree where the failure occurred.
     */
    public function getPath(): Path
    {
        return $this->path;
    }
}