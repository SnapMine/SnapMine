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
    protected array $paletteUsage;

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
            $this->paletteUsage = [4096];
        } else {
            $this->bitsPerEntry = max(4, (int)ceil(log(count($this->palette), 2)));
            $this->paletteUsage = array_fill(0, count($this->palette), 0);

            for ($i = 0; $i < 4096; $i++) {
                $this->paletteUsage[$this->getIndexInPalette($i)]++;
            }
        }
    }

    private function addToPalette(int $newBlock): void
    {
        $newBitsPerEntry = max(4, (int)ceil(log(count($this->palette) + 1, 2)));
        if($newBitsPerEntry !== $this->bitsPerEntry) {
            $this->repack($newBitsPerEntry);
        }

        $this->palette[] = $newBlock;
        $this->paletteUsage[] = 0;

    }

    private function repack($newBpe): void
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

        $this->data = $newData;
        $this->bitsPerEntry = $newBpe;
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

    public function getNumberOf(mixed $paletteValue) {
        $paletteIndex = array_search($paletteValue, $this->palette);

        if($paletteIndex === false) {
            return 0;
        }

        return $this->paletteUsage[$paletteIndex];
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function getIndexInPalette(int $value): int
    {
        $bpe = $this->bitsPerEntry;

        if ($this->bitsPerEntry == 0) {
            return 0;
        }

        $valsPerLong = intdiv(64, $bpe);

        $longIndex = intdiv($value, $valsPerLong);
        $inLongIdx = $value % $valsPerLong;
        $bitInLong = $inLongIdx * $bpe;

        if (!isset($this->data[$longIndex])) {
            throw new OutOfBoundsException("Long index {$longIndex} does not exist in the data array.");
        }

        $mask = (1 << $bpe) - 1;
        $lo = $this->data[$longIndex];

        return ($lo >> $bitInLong) & $mask;
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!is_int($offset) || $offset < 0 || $offset >= 4096) {
            throw new InvalidArgumentException("Offset must be an integer in [0..4095].");
        }

        return $this->palette[$this->getIndexInPalette($offset)];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_int($offset) || $offset < 0 || $offset >= 4096) {
            throw new InvalidArgumentException("Offset must be an integer in [0..4095].");
        }

        $paletteIndex = array_search($value, $this->palette);

        if ($paletteIndex === false) {
            $this->addToPalette($value);
            $paletteIndex = count($this->palette) - 1;
        }

        $this->paletteUsage[$paletteIndex]++;
        $this->paletteUsage[$this->getIndexInPalette($offset)]--;

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