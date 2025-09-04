<?php

namespace SnapMine\Command\ArgumentTypes;

use SnapMine\Network\Serializer\PacketSerializer;

/**
 * @extends CommandArgumentType<string>
 */
class BrigadierString extends CommandArgumentType
{
    public const SINGLE_WORD = 0, QUOTABLE_PHRASE = 1, GREEDY_PHRASE = 2;

    private string $value = '';


    public function __construct(
        private readonly int $type = self::SINGLE_WORD
    )
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

    public function encodeProperties(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->type);
    }
}