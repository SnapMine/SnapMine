<?php

namespace Nirbose\PhpMcServ\Network\Packet;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

abstract class Packet
{

    abstract public function getId(): int;

    abstract public function write(PacketSerializer $serializer): void;

    abstract public function read(PacketSerializer $serializer, string $buffer, int &$offset): void;

    abstract public function handle(Session $session): void;
}