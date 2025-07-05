<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ConfirmTeleportationPacket extends Packet
{
    private int $teleportId;

    public function getId(): int
    {
        return 0x00;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->teleportId = $serializer->getVarInt($buffer, $offset);
    }

    public function handle(Session $session): void
    {
//        $session->getServer()->testSheep(
//            $session->getServer()->getPlayers()[0]
//        );
    }
}