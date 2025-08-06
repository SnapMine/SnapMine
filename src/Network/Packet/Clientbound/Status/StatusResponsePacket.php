<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Status;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class StatusResponsePacket extends ClientboundPacket
{

    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function getId(): int
    {
        return 0x00;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->data);
    }
}