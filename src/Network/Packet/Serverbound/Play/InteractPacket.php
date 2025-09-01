<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;


class InteractPacket extends ServerboundPacket
{
    private int $entityId;
    private int $type;
    private ?float $targetX = null;
    private ?float $targetY = null;
    private ?float $targetZ = null;
    private ?int $hand = null;
    private bool $sneakKeyPressed;

    public function getId(): int
    {
        return 0x18;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->entityId = $serializer->getVarInt();
        $this->type = $serializer->getVarInt();

        if ($this->type == 2) {
            $this->targetX = $serializer->getFloat();
            $this->targetY = $serializer->getFloat();
            $this->targetZ = $serializer->getFloat();
            $this->hand = $serializer->getVarInt();
        }

        if ($this->type == 0) {
            $this->hand = $serializer->getVarInt();
        }

        $this->sneakKeyPressed = $serializer->getBool();
    }

    public function handle(Session $session): void
    {
        if ($this->type == 1) {
            $session->getServer()->getWorld('world')->removeEntityById($this->entityId);
        }
    }
}