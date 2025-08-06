<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Position;

class PickItemFromBlockPacket extends ServerboundPacket
{
    private Position $position;
    private bool $includeData;

    public function getId(): int
    {
        return 0x22;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->position = $serializer->getPosition();
        $this->includeData = $serializer->getBool();
    }
}