<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Position;

class PlayerActionPacket extends Packet {
    private int $status;
    private Position $position;
    private int $face;
    private int $sequence;

    public function getId(): int
    {
        return 0x27;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->status = $serializer->getVarInt($buffer, $offset);
        $this->position = $serializer->getPosition($buffer, $offset);
        $this->face = $serializer->getByte($buffer, $offset);
        $this->sequence = $serializer->getVarInt($buffer, $offset);
    }

    public function handle(Session $session): void
    {
    }
}