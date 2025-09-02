<?php

namespace SnapMine\Command\ArgumentTypes;

/**
 * @template T
 */
abstract class ArgumentType
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
}