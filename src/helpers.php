<?php

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Server;

/**
 * Dumps packet information for debugging purposes.
 * 
 * This function serializes a clientbound packet and displays its information
 * in a human-readable format, including the packet name, ID, and hexadecimal
 * representation of the serialized data.
 * 
 * @param ClientboundPacket $packet The packet to dump
 * @return void
 * 
 * @throws \ReflectionException If reflection operations fail
 * 
 * @example
 * ```php
 * $packet = new SomeClientboundPacket();
 * packet_dump($packet);
 * // Output:
 * // SomeClientboundPacket (ID: 42) :
 * //   - Hex : 2a48656c6c6f20576f726c64
 * ```
 * 
 * @since 1.0.0
 */
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

/**
 * Check if an object uses a specific trait.
 * 
 * This function determines whether a given object's class uses a particular trait.
 * It uses the class_uses() function to get all traits used by the object's class
 * and checks if the specified trait is among them.
 * 
 * @param string $trait  The fully qualified trait name to check for
 * @param object $object The object to inspect
 * @return bool True if the object's class uses the trait, false otherwise
 * 
 * @example
 * ```php
 * class MyClass {
 *     use SomeTrait;
 * }
 * 
 * $obj = new MyClass();
 * if (has_trait(SomeTrait::class, $obj)) {
 *     // Object uses SomeTrait
 * }
 * ```
 * 
 * @since 1.0.0
 */
if (!function_exists('has_trait')) {
    function has_trait(string $trait, object $object): bool
    {
        $traits = class_uses($object);

        return in_array($trait, $traits);
    }
}

if (!function_exists('server')) {
    function server(): Server
    {
        static $server = new Server();

        return $server;
    }
}