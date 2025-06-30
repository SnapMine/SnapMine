<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PluginMessagePacket extends Packet
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

    public function handle(Session $session): void
    {
    }
}