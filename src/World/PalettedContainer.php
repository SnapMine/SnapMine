<?php

namespace Nirbose\PhpMcServ\World;

use ArrayAccess;
use Aternos\Nbt\Tag\CompoundTag;
use Iterator;

abstract class PalettedContainer implements ArrayAccess, Iterator
{
    protected int $bitsPerEntry;

    /**
     * @param array $palette
     * @param array $data
     */
    public function __construct(
        protected array $palette,
        protected array $data,
    )
    {
        $this->bitsPerEntry = (int)ceil(log(count($this->palette), 2));
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function current(): mixed
    {
        return current($this->data);
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * @inheritDoc
     */
    public function key(): string|int|null
    {
        return key($this->data);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return current($this->data) !== false;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        reset($this->data);
    }
}