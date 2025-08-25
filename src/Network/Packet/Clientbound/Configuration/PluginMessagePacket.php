<?php

namespace SnapMine\Network\Packet\Clientbound\Configuration;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class PluginMessagePacket extends ClientboundPacket
{

    private string $channel;
    private array $data;

    public function __construct(string $channel, array $data)
    {
        $this->channel = $channel;
        $this->data = $data;
    }

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->channel);
        $serializer->putByteArray($this->data);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \Exception("Not implemented");
    }
}