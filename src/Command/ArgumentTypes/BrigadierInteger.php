<?php

namespace SnapMine\Command\ArgumentTypes;

use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\Flags;

class BrigadierInteger extends CommandArgumentType
{
    use Flags;


    private int $value = 0;

    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
    )
    {
        if ($min !== null) {
            $this->setFlag(0x1, true);
        }

        if ($max !== null) {
            $this->setFlag(0x2, true);
        }
    }

    static function getNumericId(): int
    {
        return 3;
    }

    /**
     * @inheritDoc
     */
    function getValue(): int
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    function encodeProperties(PacketSerializer $serializer): void
    {
        $serializer->putByte($this->flags);

        if ($this->hasFlag(0x1)) {
            $serializer->putInt($this->min);
        }

        if ($this->hasFlag(0x2)) {
            $serializer->putInt($this->max);
        }
    }

    function parse(array $args): ?array
    {
        if(is_numeric($args[0])) {
            $int = (int)$args[0];
            if (($this->min !== null && $int < $this->min) || ($this->max !== null && $int > $this->max)) {
                return null;
            }
            $copy = clone $this;
            $copy->setValue($int);
            return [array_slice($args, 1), $copy];
        } else {
            return null;
        }
    }
}