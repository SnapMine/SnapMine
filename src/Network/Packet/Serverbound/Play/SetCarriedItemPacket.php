<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetCarriedItemPacket extends ServerboundPacket
{
    private int $slot;

    public function getId(): int
    {
        return 0x33;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->slot = $serializer->getShort();
    }

}