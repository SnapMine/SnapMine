<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Status;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class StatusResponsePacket extends Packet
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

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->data = $serializer->getString($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        // No action needed for StatusResponse packet
    }
}