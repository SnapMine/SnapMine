<?php

namespace SnapMine\Network\Packet\Serverbound\Configuration;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class ClientInformationPacket extends ServerboundPacket
{

    /** @phpstan-ignore property.onlyWritten */
    private string $locale;
    /** @phpstan-ignore property.onlyWritten */
    private int $viewDistance;
    /** @phpstan-ignore property.onlyWritten */
    private int $chatMode;
    /** @phpstan-ignore property.onlyWritten */
    private bool $chatColors;
    /** @phpstan-ignore property.onlyWritten */
    private int $displayedSkinParts;
    /** @phpstan-ignore property.onlyWritten */
    private int $mainHand;
    /** @phpstan-ignore property.onlyWritten */
    private bool $enableTextFiltering;
    /** @phpstan-ignore property.onlyWritten */
    private bool $allowServerListings;
    /** @phpstan-ignore property.onlyWritten */
    private int $particleStatus;

    public function getId(): int
    {
        return 0x00;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->locale = $serializer->getString();
        $this->viewDistance = $serializer->getByte();
        $this->chatMode = $serializer->getVarInt();
        $this->chatColors = $serializer->getBool();
        $this->displayedSkinParts = $serializer->getUnsignedByte();
        $this->mainHand = $serializer->getVarInt();
        $this->enableTextFiltering = $serializer->getBool();
        $this->allowServerListings = $serializer->getBool();
        $this->particleStatus = $serializer->getVarInt();
    }
}