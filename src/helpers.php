<?php

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

if (!function_exists('packet_dump')) {
    function packet_dump(ClientboundPacket $packet): void
    {
        $serializer = new PacketSerializer('');
        $class = new ReflectionClass($packet);

        $packetName = $class->getShortName();
        $packetId = $packet->getId();

        $packet->write($serializer);

        $packetData = bin2hex(chr($packetId)) . bin2hex($serializer->get());

        echo "$packetName (ID: $packetId) :\n";
        echo "  - Hex : $packetData\n";
    }
}

if (!function_exists('has_trait')) {
    function has_trait(string $trait, object $object): bool
    {
        $traits = class_uses($object);

        return in_array($trait, $traits);
    }
}