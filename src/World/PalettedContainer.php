<?php

namespace Nirbose\PhpMcServ\World;

use ArrayAccess;
use Aternos\Nbt\Tag\CompoundTag;
use InvalidArgumentException;
use Iterator;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;
use RuntimeException;


// Pas besoin de sous-classes en fait, on l'utilise comme un array
class PalettedContainer implements ArrayAccess
{
    protected int $bitsPerEntry;

    /**
     * @param array $palette
     * @param array $data
     */
    public function __construct(
        protected readonly array $palette,
        protected array          $data,
    )
    {
        if(count($this->palette) == 1) {
            $this->bitsPerEntry = 0;
        } else {
            $this->bitsPerEntry = max(4, (int)ceil(log(count($this->palette), 2)));
        }
    }


    public function getData(): array
    {
        return $this->data;
    }

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

        if($this->bitsPerEntry == 0) {
            return $this->palette[0];
        }

        $valsPerLong = intdiv(64, $bpe);

        $longIndex = intdiv($offset, $valsPerLong);
        $inLongIdx = $offset % $valsPerLong;
        $bitInLong = $inLongIdx * $bpe;

        $mask = (1 << $bpe) - 1;

        $lo = $this->data[$longIndex] ?? 0;
        $indexInPalette = ($lo >> $bitInLong) & $mask;

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
        if (!is_int($value)) {
            throw new InvalidArgumentException("Value must be an integer (palette index).");
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
        $value    &= $maskEntry;                     // clamp à la largeur
        $FULL64    = 0xFFFFFFFFFFFFFFFF;

        // S'assurer que le slot existe
        if (!isset($this->data[$longIndex])) {
            $this->data[$longIndex] = 0;
        }

        $clear = $FULL64 ^ (($maskEntry << $bitInLong) & $FULL64);
        $cur   = $this->data[$longIndex] & $FULL64;

        $cur   = ($cur & $clear) | ((($value & $maskEntry) << $bitInLong) & $FULL64);
        $this->data[$longIndex] = $cur;
    }


    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    // J'ai supprimé Iterator pour l'instant parce que les valeurs étaient celle de
    // la data mais brute. On itérera avec un compteur pour l'instant.
    // A voir si on l'implémente plus tard.
}