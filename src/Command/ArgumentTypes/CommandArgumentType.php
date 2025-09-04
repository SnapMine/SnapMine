<?php

namespace SnapMine\Command\ArgumentTypes;

use SnapMine\Network\Serializer\PacketSerializer;

/**
 * @template T
 */
abstract class CommandArgumentType
{
    abstract static function getNumericId(): int;

    /**
     * @return T
     */
    abstract function getValue(): mixed;


    /**
     * @param T $value
     */
    abstract function setValue(mixed $value): void;

    abstract function encodeProperties(PacketSerializer $serializer): void;
}