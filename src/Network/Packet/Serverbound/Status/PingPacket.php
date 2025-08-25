<?php

namespace SnapMine\Network\Packet\Serverbound\Status;

use SnapMine\Network\Packet\Clientbound\Status\PongPacket;
use SnapMine\Network\Packet\Packet;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

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