<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\UUID;

class PlayerInfoRemovePacket extends ClientboundPacket
{
    /**
     * @param UUID[] $uuids
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