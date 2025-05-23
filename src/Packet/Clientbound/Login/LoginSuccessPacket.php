<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Login;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Protocol;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Packet\Clientbound\Configuration\PluginMessagePacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Status\StatusResponsePacket;
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
        $session->username = $this->username;
        $session->uuid = $this->uuid;
        $session->sendPacket(new PluginMessagePacket());
        $session->sendPacket(new StatusResponsePacket(json_encode([
            "version" => [
                "name" => Protocol::PROTOCOL_NAME,
                "protocol" => Protocol::PROTOCOL_VERSION,
            ],
            "players" => [
                "max" => 20,
                "online" => 0,
                "sample" => [],
            ],
            "description" => [
                "text" => "Welcome to the server!",
            ],
        ])));
    }
}