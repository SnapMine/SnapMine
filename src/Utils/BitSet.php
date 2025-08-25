<?php

namespace SnapMine\Utils;


class BitSet
{
    private string $data;

    public function __construct(int $size = 0)
    {
        $this->data = str_repeat("\x00", intdiv($size + 7, 8));
    }

    public static function fromBinary(string $binary): self
    {
        $bitSet = new self();
        $bitSet->data = $binary;
        return $bitSet;
    }

    public function get(int $index): bool
    {
        $byteIndex = intdiv($index, 8);
        $bitIndex = $index % 8;

        if (!isset($this->data[$byteIndex])) {
            return false;
        }

        return (ord($this->data[$byteIndex]) & (1 << $bitIndex)) !== 0;
    }

    public function set(int $index, bool $value): void
    {
        $byteIndex = intdiv($index, 8);
        $bitIndex = $index % 8;

        if (!isset($this->data[$byteIndex])) {
            $this->data = str_pad($this->data, $byteIndex + 1, "\x00");
        }

        $byte = ord($this->data[$byteIndex]);

        if ($value) {
            $byte |= (1 << $bitIndex);
        } else {
            $byte &= ~(1 << $bitIndex);
        }

        $this->data[$byteIndex] = chr($byte);
    }

    public function getRaw(): string
    {
        return $this->data;
    }

    public function getSize(): int
    {
        return strlen($this->data) * 8;
    }

    public function __toString(): string
    {
        $bits = [];
        for ($i = 0; $i < $this->getSize(); $i++) {
            $bits[] = $this->get($i) ? '1' : '0';
        }
        return implode('', $bits);
    }
}