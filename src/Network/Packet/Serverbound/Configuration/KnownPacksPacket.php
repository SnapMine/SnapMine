<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration\FinishConfigurationPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration\RegistryDataPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class KnownPacksPacket extends ServerboundPacket
{

    private array $packs;

    public function getId(): int
    {
        return 0x07;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->packs = [];
        $packCount = $serializer->getVarInt();

        for ($i = 0; $i < $packCount; $i++) {
            $namespace = $serializer->getString();
            $packName = $serializer->getString();
            $packVersion = $serializer->getString();
            $this->packs[$namespace] = [
                'name' => $packName,
                'version' => $packVersion,
            ];
        }
    }

    public function handle(Session $session): void
    {
        $json = file_get_contents('./resources/registry_data.json');
        $registries = json_decode($json);

        foreach ($registries as $id => $registry) {
            $packet = new RegistryDataPacket($id, $registry);

            $session->sendPacket($packet);
        }

        $session->sendPacket(new FinishConfigurationPacket());
    }
}