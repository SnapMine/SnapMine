<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ClientInformationPacket extends Packet
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

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
        $this->locale = $in->getString($buffer, $offset);
        $this->viewDistance = $in->getByte($buffer, $offset);
        $this->chatMode = $in->getVarInt($buffer, $offset);
        $this->chatColors = $in->getBool($buffer, $offset);
        $this->displayedSkinParts = $in->getUnsignedByte($buffer, $offset);
        $this->mainHand = $in->getVarInt($buffer, $offset);
        $this->enableTextFiltering = $in->getBool($buffer, $offset);
        $this->allowServerListings = $in->getBool($buffer, $offset);
        $this->particleStatus = $in->getVarInt($buffer, $offset);
    }

    public function write(PacketSerializer $out): void
    {
        // Not implemented
    }

    public function handle(Session $session): void
    {
        // Not implemented
    }
}