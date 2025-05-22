<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\DataType\VarInt;

class Connection
{
    private $socket;

    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    public function readPacket(int $length = 2048): ?string
    {
        $data = @socket_read($this->socket, $length);
        return $data ?: null;
    }

    public function writePacket(string $payload): void
    {
        $serializer = new PacketSerializer();
        $serializer->putVarInt(strlen($payload));

        $this->writeRaw($serializer->get() . $payload);
    }

    public function writeRaw(string $data): void
    {
        // echo "➡️ Paquet envoyé (hex) : " . bin2hex($data) . "\n";
        socket_write($this->socket, $data);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }
}
