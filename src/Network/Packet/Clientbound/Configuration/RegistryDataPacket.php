<?php

namespace SnapMine\Network\Packet\Clientbound\Configuration;

use SnapMine\Keyed;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Registry\EncodableToNbt;

class RegistryDataPacket extends ClientboundPacket
{
    /**
     * @param string $registryId
     * @param array<string, EncodableToNbt> $entries
     */
    public function __construct(
        private readonly string $registryId,
        private readonly array $entries
    )
    {
    }

    public function getId(): int
    {
        return 0x07;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->registryId)
            ->putVarInt(count($this->entries));

        foreach ($this->entries as $entry) {
            if (!($entry instanceof Keyed)) {
                continue;
            }

            $serializer->putString($entry->getKey())
                ->putBool(true)
                ->putNBT($entry->toNbt());
        }
    }
}