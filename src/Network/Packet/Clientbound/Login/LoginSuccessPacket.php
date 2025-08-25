<?php

namespace SnapMine\Network\Packet\Clientbound\Login;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\UUID;

class LoginSuccessPacket extends ClientboundPacket
{
    private string $username;
    private UUID $uuid;

    public function __construct(string $username, UUID $uuid)
    {
        $this->username = $username;
        $this->uuid = $uuid;
    }

    public function getId(): int
    {
        return 0x02;
    }

    public function write(PacketSerializer $serializer): void
    {        
        $serializer->putUUID($this->uuid)
            ->putString($this->username)
            ->putVarInt(0);
    }
}