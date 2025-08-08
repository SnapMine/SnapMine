<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class KeepAlivePacket extends ServerboundPacket {
    private int $keepAliveId;

    public function getId(): int {
        return 0x1A;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->keepAliveId = $serializer->getLong();
    }

}