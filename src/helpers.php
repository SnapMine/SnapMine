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

if (!function_exists('class_uses_recursive')) {
    function class_uses_recursive(string $class): array {
        $results = [];

        $results = array_merge($results, class_uses($class) ?: []);

        if ($parent = get_parent_class($class)) {
            $results = array_merge($results, class_uses_recursive($parent));
        }

        foreach (class_uses($class) ?: [] as $usedTrait) {
            $results = array_merge($results, class_uses_recursive($usedTrait));
        }

        return array_unique($results);
    }
}

if (!function_exists('has_trait')) {
    /**
     * @template T of object
     * @template U of object
     * @param class-string<U> $trait
     * @param T $object
     * @phpstan-assert-if-true U $object
     */
    function has_trait(string $trait, object $object): bool
    {
        return in_array($trait, class_uses_recursive($object::class), true);
    }
}