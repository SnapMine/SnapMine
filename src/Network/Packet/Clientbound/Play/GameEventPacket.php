<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class GameEventPacket extends Packet {

    private int $eventId;
    private float $value;

    public function __construct(int $eventId = 0, float $value = 0.0)
    {
        $this->eventId = $eventId;
        $this->value = $value;
    }

    public function getId(): int
    {
        return 0x22;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putUnsignedByte($this->eventId);
        $serializer->putFloat($this->value);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}