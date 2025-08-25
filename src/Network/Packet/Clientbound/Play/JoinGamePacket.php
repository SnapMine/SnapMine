<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class JoinGamePacket extends ClientboundPacket
{
    public function __construct(
        private readonly Player $player
    )
    {
    }

    public function getId(): int
    {
        return 0x2B;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->player->getId()) // Entity ID
            ->putBool(false) // Hardcore
            ->putVarInt(1) // Dimension Names (Prefixed Array of Identifier)
            ->putString("minecraft:overworld")

            ->putVarInt($this->player->getServer()->getMaxPlayer()) // Max player
            ->putVarInt(8) // View distance
            ->putVarInt(8) // Simulation Distance
            ->putBool(false) // Reduced Debug Info
            ->putBool(true) // Enable Respawn Screen
            ->putBool(false) // Do Limit Crafting
            ->putVarInt(0) // ID of minecraft:overworld
            ->putString('minecraft:overworld') // Dimension Name
            ->putLong(234345456) // Hashed Seed
            ->putUnsignedByte($this->player->getGameMode()->value) // Game Mode
            ->putByte($this->player->getPreviousGameMode()->value ?? -1) // Previous Game Mode (-1 undefined)
            ->putBool(false) // Is Debug
            ->putBool(true) // Is Flat
            ->putBool(false) // Has Death Location
            ->putVarInt(0) // Portal Cooldown
            ->putVarInt(63) // Sea Level
            ->putBool(false); // Enforces Secure Chat
    }
}