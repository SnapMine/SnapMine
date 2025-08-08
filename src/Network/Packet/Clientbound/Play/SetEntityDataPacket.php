<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class SetEntityDataPacket extends ClientboundPacket
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


}