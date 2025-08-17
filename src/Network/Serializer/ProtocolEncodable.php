<?php

namespace Nirbose\PhpMcServ\Network\Serializer;

interface ProtocolEncodable
{
    public function toPacket(PacketSerializer $serializer): void;
}