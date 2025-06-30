<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PluginMessagePacket extends Packet
{
    public string $channel;
    public array $data;

    public function getId(): int
    {
        return 0x02;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
        $this->channel = $in->getString($buffer, $offset);
        $this->data = $in->getByteArray($buffer, $offset);
    }

    public function write(PacketSerializer $out): void
    {
        // Not implemented
    }

    public function handle(Session $session): void
    {
        // var_dump("PluginMessagePacket: Channel: " . $this->channel);
        // var_dump("PluginMessagePacket: Data: ", $this->data);

        // $session->sendPacket(new ConfigurationPluginMessagePacket($this->channel, $this->data));
    }
}