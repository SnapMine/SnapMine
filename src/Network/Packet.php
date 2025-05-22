<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

abstract class Packet
{

    abstract public function getId(): int;

    abstract public function write(PacketSerializer $serializer): void;

    abstract public function read(PacketSerializer $serializer, string $buffer, int &$offset): void;
}