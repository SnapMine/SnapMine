<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SwingPacket extends ServerboundPacket {

    public function getId(): int {
        return 0x3B;
    }

    /**
     * @throws \Exception
     */
    public function read(PacketSerializer $serializer): void {
        $serializer->getVarInt();
    }
}