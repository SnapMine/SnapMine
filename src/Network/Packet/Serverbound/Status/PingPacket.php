<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Status;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Status\PongPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PingPacket extends ServerboundPacket
{
    public int $payload;

    public function getId(): int
    {
        return 0x01;
    }

    /**
     * @throws \Exception
     */
    public function read(PacketSerializer $in): void
    {
        $this->payload = $in->getLong();
    }


    public function handle(Session $session): void
    {
        $pong = new PongPacket($this->payload);

        $session->sendPacket($pong);
    }
}