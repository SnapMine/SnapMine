<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class AnimatePacket extends ClientboundPacket
{
    public function __construct(
        private readonly Player $player,
        private readonly int $animationId,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer
            ->putVarInt($this->player->getId())
            ->putUnsignedByte($this->animationId);
    }

    public function getId(): int
    {
        return 0x02;
    }
}