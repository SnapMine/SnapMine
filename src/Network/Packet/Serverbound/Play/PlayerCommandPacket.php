<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class PlayerCommandPacket extends ServerboundPacket {
    private int $entityId;
    private int $actionId;
    private int $jumpBoost;

    public function getId(): int
    {
        return 0x28;
    }

    /**
     * @throws \Exception
     */
    public function read(PacketSerializer $serializer): void
    {
        $this->entityId = $serializer->getVarInt();
        $this->actionId = $serializer->getVarInt();
        $this->jumpBoost = $serializer->getVarInt();
    }


    public function handle(Session $session): void
    {
        
    }
}