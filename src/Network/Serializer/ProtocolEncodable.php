<?php

namespace SnapMine\Network\Serializer;

interface ProtocolEncodable
{
    public function encode(PacketSerializer $serializer): void;
}