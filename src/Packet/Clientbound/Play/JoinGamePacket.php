<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class JoinGamePacket extends Packet
{
    public function getId(): int
    {
        return 0x2B;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \Exception("JoinGamePacket ne peut pas être reçu");
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putInt(42); // Entity ID
        $serializer->putBool(false); // Is Hardcore
        $serializer->putPrefixedArray([
            'minecraft:overworld',
        ]);
        $serializer->putVarInt(100); // Max Playerss
        $serializer->putVarInt(10); // View Distance
        $serializer->putVarInt(10); // Simulation Distance
        $serializer->putBool(false); // Reduced Debug Info
        $serializer->putBool(true); // Enable Respawn Screen
        $serializer->putBool(false); // Do Limited Crafting
        $serializer->putVarInt(0); // Dimension Type ID
        $serializer->putString('minecraft:overworld'); // Dimension Name
        $serializer->putLong(0); // Hashed seed
        $serializer->putByte(0); // Game Mode
        $serializer->putByte(-1); // Previous Game Mode
        $serializer->putBool(false); // Is Debug
        $serializer->putBool(false); // Is Flat
        $serializer->putBool(false); // Has death location
        $serializer->putString('minecraft:overworld');
        $serializer->putPosition(0, 0, 0); // Spawn position
        $serializer->putVarInt(0); // Portal cooldown
        $serializer->putVarInt(63); // Sea level
        $serializer->putBool(false); // Enforces Secure Chat
    }

    public function handle(Session $session): void
    {
    }
}
