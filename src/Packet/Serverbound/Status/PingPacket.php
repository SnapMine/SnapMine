<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Status;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Packet\Clientbound\Status\PongPacket;
use Nirbose\PhpMcServ\Session\Session;

class PingPacket extends Packet
{
    public int $payload;

    public function getId(): int
    {
        return 0x01;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
        $this->payload = $in->getLong($buffer, $offset);
    }

    public function write(PacketSerializer $out): void {}

    public function handle(Session $session): void
    {
        $pong = new PongPacket($this->payload);

        $session->sendPacket($pong);
    }
}