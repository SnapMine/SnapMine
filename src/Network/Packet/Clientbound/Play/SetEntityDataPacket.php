<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class SetEntityDataPacket extends Packet
{
    public function __construct(
        private readonly int $entityId,
        private readonly PacketSerializer $data,
    ) {
    }

    public function getId(): int
    {
        return 0x5C;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->entityId);

        $this->data->putUnsignedByte(0xFF);

        $serializer->put($this->data->get());
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }

    public function handle(Session $session): void
    {
    }
}