<?php

namespace SnapMine\Command\ArgumentTypes;

/**
 * @extends ArgumentType<string>
 */
class BrigadierString extends ArgumentType
{
    public const SINGLE_WORD = 0, QUOTABLE_PHRASE = 1, GREEDY_PHRASE = 2;

    private string $value = '';



    public function __construct(private int $type = self::SINGLE_WORD)
    {
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function getNumericId(): int
    {
        return 5;
    }
}