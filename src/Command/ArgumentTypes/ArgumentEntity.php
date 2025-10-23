<?php

namespace SnapMine\Command\ArgumentTypes;

use SnapMine\Entity\Player;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\Flags;

class ArgumentEntity extends CommandArgumentType
{
    use Flags;

    const FLAG_SINGLE = 0x1;
    const FLAG_ONLY_PLAYERS = 0x2;

    private ?Player $player = null;

    public function __construct(
        private readonly bool $single = true,
        private readonly bool $onlyPlayers = false
    )
    {
        if ($single) {
            $this->setFlag(self::FLAG_SINGLE, true);
        }

        if ($onlyPlayers) {
            $this->setFlag(self::FLAG_ONLY_PLAYERS, true);
        }
    }

    static function getNumericId(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    function getValue(): ?Player
    {
        return $this->player;
    }

    /**
     * @inheritDoc
     */
    function setValue(mixed $value): void
    {
        $this->player = $value;
    }

    function encodeProperties(PacketSerializer $serializer): void
    {
        $serializer->putByte($this->flags);
    }

    function parse(array $args): ?array
    {
        $clone = clone $this;

        $playerName = $args[0];
        foreach (server()->getPlayers() as $player) {
            if ($player->getName() === $playerName || $player->getUuid()->toString() === $playerName) {
                $clone->player = $player;

                return [array_slice($args, 1), $clone];
            }
        }


        return null;
    }
}