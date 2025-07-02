<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
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
        // Entity ID
        $serializer->putInt(0);
        
        // Is Hardcore
        $serializer->putBool(false);
        
        // Dimension Names (Prefixed Array of Identifier) - NOUVEAU FORMAT
        $serializer->putVarInt(1);
        $serializer->putString("minecraft:overworld");
        
        // Max Players
        $serializer->putVarInt(100);

        // View Distance
        $serializer->putVarInt(10);

        // Simulation Distance
        $serializer->putVarInt(10);
        
        // Reduced Debug Info
        $serializer->putBool(false);
        
        // Enable Respawn Screen
        $serializer->putBool(true);
        
        // Do Limited Crafting
        $serializer->putBool(false);

        $serializer->putVarInt(0); // ID de minecraft:overworld dans le registre

        // Dimension Name
        $serializer->putString('minecraft:overworld');
        
        // Hashed Seed
        $serializer->putLong(234345456);
        
        // Game Mode
        $serializer->putUnsignedByte(1); // Survival
        
        // Previous Game Mode
        $serializer->putByte(-1); // Undefined
        
        // Is Debug
        $serializer->putBool(false);
        
        // Is Flat
        $serializer->putBool(false);
        
        // Has Death Location
        $serializer->putBool(false);
        
        // Portal Cooldown
        $serializer->putVarInt(0);
        
        // Sea Level
        $serializer->putVarInt(63);
        
        // Enforces Secure Chat
        $serializer->putBool(false);
    }

    public function handle(Session $session): void
    {
        // Traitement après envoi du packet
    }
}