<?php

namespace SnapMine\Network\Packet\Serverbound\Login;

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\Login\DisconnectPacket;
use SnapMine\Network\Packet\Clientbound\Login\LoginSuccessPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\Utils\UUID;

class LoginStartPacket extends ServerboundPacket
{
    private string $username;

    public function getId(): int
    {
        return 0x00;
    }

    /**
     * @throws \Exception
     */
    public function read(PacketSerializer $serializer): void
    {
        $this->username = $serializer->getString();
    }

    public function handle(Session $session): void
    {
        if (count($session->getServer()->getWorlds()) === 0) {
            $session->sendPacket(new DisconnectPacket(TextComponent::text("No Worlds found.")));
            return;
        }

        $session->username = $this->username;
        $session->uuid = UUID::generateOffline($this->username);

        $session->sendPacket(new LoginSuccessPacket($this->username, $session->uuid));
    }
}