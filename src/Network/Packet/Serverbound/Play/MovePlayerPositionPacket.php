<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\MoveEntityPosPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerPositionPacket extends Packet
{
    private float $x;
    private float $feetY;
    private float $z;
    private bool $flags;

    public function getId(): int
    {
        return 0x1C;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->x = $serializer->getDouble($buffer, $offset);
        $this->feetY = $serializer->getDouble($buffer, $offset);
        $this->z = $serializer->getDouble($buffer, $offset);
        $this->flags = $serializer->getByte($buffer, $offset);
    }

    public function write(PacketSerializer $serializer): void
    {
        throw new \Exception("MovePlayerPositionPacket cannot be sent");
    }

    public function handle(Session $session): void
    {
        $player = $session->getPlayer();
        $loc = $player->getLocation();

        $factor = 4096;

        $deltaX = (int)(($this->x - $loc->getX()) * $factor);
        $deltaY = (int)(($this->feetY - $loc->getY()) * $factor);
        $deltaZ = (int)(($this->z - $loc->getZ()) * $factor);

        $maxDelta = 32767; // max short
        if (abs($deltaX) > $maxDelta || abs($deltaY) > $maxDelta || abs($deltaZ) > $maxDelta) {
            // Utiliser TeleportEntityPacket à la place
            return;
        }

        $loc->setX($this->x);
        $loc->setY($this->feetY);
        $loc->setZ($this->z);

        $outPacket = new MoveEntityPosPacket(
            $player->getId(),
            $deltaX,
            $deltaY,
            $deltaZ,
            false
        );

        foreach ($session->getServer()->getPlayers() as $player) {
            if ($player === $session->getPlayer()) {
                continue;
            }

            $player->sendPacket($outPacket);
        }
    }
}