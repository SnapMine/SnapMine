<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ClientInformationPacket extends ServerboundPacket
{

    private string $locale;
    private string $viewDistance;
    private string $chatMode;
    private bool $chatColors;
    private int $displayedSkinParts;
    private int $mainHand;
    private bool $enableTextFiltering;
    private bool $allowServerListings;
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