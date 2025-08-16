<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\MoveEntityPosRotPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\RotateHeadPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class MovePlayerPositionRotationPacket extends ServerboundPacket
{

    private float $x;
    private float $feetY;
    private float $z;
    private float $yaw;
    private float $pitch;
    /** @phpstan-ignore property.onlyWritten */
    private bool $flags;

    public function getId(): int
    {
        return 0x1D;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->x = $serializer->getDouble();
        $this->feetY = $serializer->getDouble();
        $this->z = $serializer->getDouble();
        $this->yaw = $serializer->getFloat();
        $this->pitch = $serializer->getFloat();
        $this->flags = $serializer->getBool();
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
        $loc->setYaw($this->yaw);
        $loc->setPitch($this->pitch);

        $outPacket = new MoveEntityPosRotPacket(
            $player->getId(),
            $deltaX,
            $deltaY,
            $deltaZ,
            $this->yaw,
            $this->pitch,
            false
        );
        $headRotatePacket = new RotateHeadPacket($player);

        foreach ($session->getServer()->getPlayers() as $player) {
            if ($player->getUuid() === $session->getPlayer()->getUuid()) {
                continue;
            }

            $player->sendPacket($outPacket);
            $player->sendPacket($headRotatePacket);
        }
    }
}