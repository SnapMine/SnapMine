<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Position;

class UseItemOnPacket extends ServerboundPacket
{
    private int $hand;
    private Position $position;
    private int $face;
    private float $cursorPositionX;
    private float $cursorPositionY;
    private float $cursorPositionZ;
    private bool $insideBlock;
    private bool $worldBorderHit;
    private int $sequence;

    public function getId(): int
    {
        return 0x3E;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->hand = $serializer->getVarInt();
        $this->position = $serializer->getPosition();
        $this->face = $serializer->getVarInt();
        $this->cursorPositionX = $serializer->getFloat();
        $this->cursorPositionY = $serializer->getFloat();
        $this->cursorPositionZ = $serializer->getFloat();
        $this->insideBlock = $serializer->getBool();
        $this->worldBorderHit = $serializer->getBool();
        $this->sequence = $serializer->getVarInt();
    }

    public function handle(Session $session): void
    {
        $server = $session->getServer();
        $block = $server
            ->getWorld("world")
            ->getChunk(((int)$this->position->getX()) >> 4, ((int)$this->position->getZ()) >> 4)
            ->getBlock((int)$this->position->getX(), (int)$this->position->getY(), (int)$this->position->getZ());

        $server->broadcastPacket(new BlockUpdatePacket($this->position, $block));
    }
}