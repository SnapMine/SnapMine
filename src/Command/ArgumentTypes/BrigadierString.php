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

    function parse(array $args): ?array
    {
        if (count($args) === 0) {
            return null;
        }

        $clone = clone $this;

        switch ($this->type) {
            case self::SINGLE_WORD:
                $clone->value = $args[0];
                return [array_slice($args, 1), $clone];
            case self::QUOTABLE_PHRASE:
                $re = '/^("((?:[^"\\\\]|\\\\.)*)"|\'((?:[^\'\\\\]|\\\\.)*)\') /s';

                $implode = implode(' ', $args) ;

                preg_match($re, $implode . " ", $matches);

                if (count($matches) === 0) {
                    return null;
                }
                $newArgs = explode(" ", substr($implode, strlen($matches[0])));
                $clone->value = stripcslashes($matches[2]);

                var_dump($newArgs);

                return [$newArgs, $clone];
            case self::GREEDY_PHRASE:
                $clone->value = implode(' ', $args);
                return [[], $clone];
            default:
                return null;
        }
    }
}