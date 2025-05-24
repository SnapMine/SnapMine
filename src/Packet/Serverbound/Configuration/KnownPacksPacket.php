<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Packet\Clientbound\Configuration\FinishConfigurationPacket;
use Nirbose\PhpMcServ\Session\Session;

class KnownPacksPacket extends Packet
{

    private array $packs;

    public function getId(): int
    {
        return 0x07;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
        $this->packs = [];
        $packCount = $in->getVarInt($buffer, $offset);

        for ($i = 0; $i < $packCount; $i++) {
            $namespace = $in->getString($buffer, $offset);
            $packName = $in->getString($buffer, $offset);
            $packVersion = $in->getString($buffer, $offset);
            $this->packs[$namespace] = [
                'name' => $packName,
                'version' => $packVersion,
            ];
        }
    }

    public function write(PacketSerializer $out): void
    {
        // No data to write for this packet
    }

    public function handle(Session $session): void
    {
        $session->sendPacket(new FinishConfigurationPacket());
    }
}