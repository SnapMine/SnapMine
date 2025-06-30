<?php

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

if (!function_exists('packet_dump')) {
    function packet_dump(Packet $packet): void
    {
        $serializer = new PacketSerializer();
        $class = new ReflectionClass($packet);

        $packetName = $class->getShortName();
        $packetId = $packet->getId();
        
        $packet->write($serializer);

        $packetData = bin2hex($serializer->get());

        echo "$packetName (ID: $packetId) :\n";
        echo "  - Hex : $packetData\n";
    }
}