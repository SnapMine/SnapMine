<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\UUID;

class PlayerInfoRemovePacket extends ClientboundPacket
{
    /**
     * @param array<UUID> $uuids
     */
    public function __construct(
        private readonly array $uuids,
    )
    {

    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt(count($this->uuids));

        foreach ($this->uuids as $uuid) {
            $serializer->putUUID($uuid);
        }
    }

    public function getId(): int
    {
        return 0x3E;
    }
}