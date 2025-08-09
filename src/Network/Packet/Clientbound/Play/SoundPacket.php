<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Sound\Sound;
use Nirbose\PhpMcServ\Sound\SoundCategory;

class SoundPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Sound $sound,
        private readonly SoundCategory $category,
        private readonly int $x,
        private readonly int $y,
        private readonly int $z,
        private readonly float $volume,
        private readonly float $pitch,
        private readonly int $seed,
    )
    {

    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->sound->value);
        $serializer->putVarInt($this->category->value);
        $serializer->putInt($this->x);
        $serializer->putInt($this->y);
        $serializer->putInt($this->z);
        $serializer->putFloat($this->volume);
        $serializer->putFloat($this->pitch);
        $serializer->putLong($this->seed);
    }

    public function getId(): int
    {
        return 0x6E;
    }
}