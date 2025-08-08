<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Login;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\UUID;

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