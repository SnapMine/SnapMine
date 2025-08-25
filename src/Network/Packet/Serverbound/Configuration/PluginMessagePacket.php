<?php

namespace SnapMine\Network\Packet\Serverbound\Configuration;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class PluginMessagePacket extends ServerboundPacket
{
    public string $channel;
    public array $data;

    public function getId(): int
    {
        return 0x02;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->channel = $serializer->getString();
        $this->data = $serializer->getByteArray();
    }

}