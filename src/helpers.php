<?php

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

if (!function_exists('packet_dump')) {
    function packet_dump(Packet $packet): void
    {
        $serializer = new PacketSerializer('');
        $class = new ReflectionClass($packet);

        $packetName = $class->getShortName();
        $packetId = $packet->getId();
        
        $packet->write($serializer);

        $packetData = bin2hex($packetId) . bin2hex($serializer->get());

        echo "$packetName (ID: $packetId) :\n";
        echo "  - Hex : $packetData\n";
    }
}

if(!function_exists("get_block_state_offset")) {
    function get_block_state_offset(array $property_values, array $property_coefficients): int
    {
        $offset = 0;

        for($i = 0; $i < count($property_values); $i++) {
            $offset += $property_values[$i] * $property_coefficients[$i];
        }

        return $offset;
    }
}