<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\MoveEntityRotPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\RotateHeadPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerRotationPacket extends ServerboundPacket {
    private float $yaw;
    private float $pitch;

    public function getId(): int
    {
        return 0x1E;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->yaw = $serializer->getFloat();
        $this->pitch = $serializer->getFloat();
    }

    public function handle(Session $session): void
    {
        $player = $session->getPlayer();
        $loc = $player->getLocation();

        $loc->setYaw($this->yaw);
        $loc->setPitch($this->pitch);

        $packet = new MoveEntityRotPacket($player, false);
        $headRotatePacket = new RotateHeadPacket($player);

        $session->getServer()->broadcastPacket($headRotatePacket, fn (Player $p) => $p->getUuid() != $player->getUuid());
        $player->getServer()->broadcastPacket($packet, fn (Player $p) => $p->getUuid() != $player->getUuid());
    }
}