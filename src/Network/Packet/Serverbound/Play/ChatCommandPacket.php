<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class ChatCommandPacket extends ServerboundPacket
{
    private string $command;

    public function getId(): int
    {
        return 0x05;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->command = $serializer->getString();
    }

    public function handle(Session $session): void
    {
        $args = explode(' ', $this->command);
        $manager = $session->getServer()->getCommandManager();

        $manager->execute($args, $session->getPlayer());
    }
}