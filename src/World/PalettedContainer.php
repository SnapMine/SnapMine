<?php

namespace SnapMine\World;

use ArrayAccess;
use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;


/**
 * @template T
 */
class PalettedContainer implements ArrayAccess
{
    protected int $bitsPerEntry;

    /**
     * @param T[] $palette
     * @param array<int> $data
     */
    public function __construct(
        protected array $palette,
        protected array $data,
    )
    {
        if (count($this->palette) == 1) {
            $this->bitsPerEntry = 0;
        } else {
            $this->bitsPerEntry = max(4, (int)ceil(log(count($this->palette), 2)));
        }
    }

    private function addToPalette(int $newBlock): void
    {
        $newBitsPerEntry = max(4, (int)ceil(log(count($this->palette)+1, 2)));
        $this->data = $this->convertDataToBpe($newBitsPerEntry);
        $this->palette[] = $newBlock;

    }

    private function convertDataToBpe($newBpe): array
    {
        $newData = [];

        $valsPerLong = intdiv(64, $newBpe);
        $arraySize = 4096 / $valsPerLong;

        for ($i = 0; $i < $arraySize; $i++) {
            $long = 0;
            for ($j = 0; $j < $valsPerLong; $j++) {
                $long >>= $newBpe;
                $long |= ($this->data[$i * $j]) << (64 - $newBpe);
            }
            $newData[] = $long;
        }

        return $newData;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return T[]
     */
    public function getPalette(): array
    {
        return $this->palette;
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
        if (!is_int($offset)) {
            throw new InvalidArgumentException("Offset must be an integer.");
        }

        $bpe = $this->bitsPerEntry;

        if ($this->bitsPerEntry == 0) {
            return $this->palette[0];
        }

        $valsPerLong = intdiv(64, $bpe);

        $longIndex = intdiv($offset, $valsPerLong);
        $inLongIdx = $offset % $valsPerLong;
        $bitInLong = $inLongIdx * $bpe;

        if (!isset($this->data[$longIndex])) {
            throw new OutOfBoundsException("Long index {$longIndex} does not exist in the data array.");
        }

        $mask = (1 << $bpe) - 1;
        $lo = $this->data[$longIndex];

        $indexInPalette = ($lo >> $bitInLong) & $mask;

        if (!isset($this->palette[$indexInPalette])) {
            throw new OutOfBoundsException("Palette index {$indexInPalette} is out of bounds for the current palette.");
        }

        return $this->palette[$indexInPalette];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_int($offset)) {
            throw new InvalidArgumentException("Offset must be an integer.");
        }
        $paletteIndex = array_search($value, $this->palette);

        if($paletteIndex === false) {
            $this->addToPalette($value);
            $paletteIndex = count($this->palette) - 1;
        }

        $bpe = $this->bitsPerEntry;
        if ($bpe <= 0) {
            throw new RuntimeException("bitsPerEntry must be > 0");
        }

        $valsPerLong = intdiv(64, $bpe);
        if ($valsPerLong <= 0) {
            throw new RuntimeException("bitsPerEntry must be <= 64");
        }


        $longIndex = intdiv($offset, $valsPerLong);
        $inLongIdx = $offset % $valsPerLong;
        $bitInLong = $inLongIdx * $bpe;

        $maskEntry = (1 << $bpe) - 1;
        $paletteIndex &= $maskEntry;

        if (!isset($this->data[$longIndex])) {
            $this->data[$longIndex] = 0;
        }

        $clear = PHP_INT_MAX ^ (($maskEntry << $bitInLong) & PHP_INT_MAX);
        $cur = $this->data[$longIndex] & PHP_INT_MAX;

        $cur = ($cur & $clear) | ((($paletteIndex & $maskEntry) << $bitInLong) & PHP_INT_MAX);
        $this->data[$longIndex] = $cur;
    }


    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }
}