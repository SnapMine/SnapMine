<?php

namespace SnapMine\Network\Packet\Clientbound\Status;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

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