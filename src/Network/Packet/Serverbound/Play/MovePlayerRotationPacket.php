<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\MoveEntityRotPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\RotateHeadPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerRotationPacket extends Packet {
    private float $yaw;
    private float $pitch;

    public function getId(): int
    {
        return 0x1E;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->yaw = $serializer->getFloat($buffer, $offset);
        $this->pitch = $serializer->getFloat($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        $player = $session->getPlayer();
        $loc = $player->getLocation();

        $loc->setYaw($this->yaw);
        $loc->setPitch($this->pitch);

        $packet = new MoveEntityRotPacket($player, false);
        $headRotatePacket = new RotateHeadPacket($player);

        foreach ($session->getServer()->getPlayers() as $player) {
            if ($player === $session->getPlayer()) {
                continue;
            }

            $player->sendPacket($packet);
            $player->sendPacket($headRotatePacket);
        }
    }
}