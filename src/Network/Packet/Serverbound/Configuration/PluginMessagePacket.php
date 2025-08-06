<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

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