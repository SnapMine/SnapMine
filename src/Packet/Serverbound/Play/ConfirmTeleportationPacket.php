<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\GameEventPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\SetCenterChunk;
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
    }
}