<?php

namespace Nirbose\PhpMcServ\Packet;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class LoginStartPacket extends Packet
{
    public string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->username = $serializer->getString($buffer, $offset);
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->username);
    }

    public function getId(): int
    {
        return 0x00;
    }
}