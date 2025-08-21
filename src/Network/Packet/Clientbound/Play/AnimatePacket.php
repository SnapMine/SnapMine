<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

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