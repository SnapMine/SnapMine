<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class PlayerInfoUpdatePacket extends Packet
{

    public function __construct()
    {
    }

    public function getId(): int
    {
        return 0x3F;
    }

    public function write(PacketSerializer $serializer): void
    {
        $actionMask = 0x01 | 0x04 | 0x10; // Add Player + Update Game Mode + Update Latency
        $serializer->putVarInt($actionMask);
        $serializer->putVarInt(1);
        $serializer->putUUID(UUID::generateOffline("teste"));

// Add Player
        $serializer->putString("teste");
        $serializer->putVarInt(1); // 1 property
        $serializer->putString("textures");
        $serializer->putString("skin-value");
        $serializer->putBool(false);

// Update Game Mode
        $serializer->putVarInt(1); // creative

// Update Latency
        $serializer->putVarInt(42); // ping in ms
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        // TODO: Implement read() method.
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}