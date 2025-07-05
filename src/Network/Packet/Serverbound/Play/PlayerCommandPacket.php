<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PlayerCommandPacket extends Packet {
    private int $entityId;
    private int $actionId;
    private int $jumpBoost;

    public function getId(): int
    {
        return 0x28;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->entityId = $serializer->getVarInt($buffer, $offset);
        $this->actionId = $serializer->getVarInt($buffer, $offset);
        $this->jumpBoost = $serializer->getVarInt($buffer, $offset);
    }

    public function write(PacketSerializer $serializer): void
    {
        
    }

    public function handle(Session $session): void
    {
        
    }
}