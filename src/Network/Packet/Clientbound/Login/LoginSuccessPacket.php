<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Login;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class LoginSuccessPacket extends Packet
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

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \RuntimeException("Not implemented");
    }

    public function write(PacketSerializer $serializer): void
    {        
        $serializer->put($this->uuid->toBinary());
        $serializer->putString($this->username);
        $serializer->putVarInt(0);
    }

    public function handle(Session $session): void
    {
    }
}