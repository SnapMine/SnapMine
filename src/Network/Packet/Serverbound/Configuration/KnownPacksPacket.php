<?php

namespace SnapMine\Network\Packet\Serverbound\Configuration;

use SnapMine\Network\Packet\Clientbound\Configuration\FinishConfigurationPacket;
use SnapMine\Network\Packet\Clientbound\Configuration\RegistryDataPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Registry\Registry;
use SnapMine\Session\Session;

class KnownPacksPacket extends ServerboundPacket
{

    /** @phpstan-ignore property.onlyWritten */
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
        $registries = Registry::cases();

        foreach ($registries as $registry) {
            $packet = new RegistryDataPacket(
                'minecraft:' . str_replace('__', '/', strtolower($registry->name)),
                $registry->value::getEntries()
            );

            $session->sendPacket($packet);
        }

        $session->sendPacket(new FinishConfigurationPacket());
    }
}