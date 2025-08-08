<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ContainerClosePacket extends ServerboundPacket
{
    private int $windowId;

    public function getId(): int
    {
        return 0x11;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->windowId = $serializer->getVarInt();
    }

}