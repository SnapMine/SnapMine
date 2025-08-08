<?php

namespace Nirbose\PhpMcServ\Network\Packet;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

interface Packet
{

    public function getId(): int;

    public function handle(Session $session): void;
}