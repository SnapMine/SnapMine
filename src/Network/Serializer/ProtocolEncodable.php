<?php

namespace SnapMine\Network\Serializer;

interface ProtocolEncodable
{
    public function toPacket(PacketSerializer $serializer): void;
}