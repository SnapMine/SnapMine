<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration\AcknowledgeFinishConfigurationPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration\ClientInformationPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration\KnownPacksPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration\PluginMessagePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Handshaking\HandshakePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Login\LoginAcknowledgedPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Login\LoginStartPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\ClientTickEndPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\ConfirmTeleportationPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\ContainerClosePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\CustomPlayLoadPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\KeepAlivePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\MovePlayerPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\MovePlayerPositionRotationPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\MovePlayerRotationPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\MovePlayerStatusOnlyPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\PickItemFromBlockPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\PlayerActionPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\PlayerCommandPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\PlayerInputPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\PlayerLoadedPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\SetCarriedItemPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\SetCreativeModeSlotPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\SwingPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Play\UseItemOnPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Status\PingPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\Status\StatusRequestPacket;

class Protocol
{
    const PROTOCOL_VERSION = 770;
    const PROTOCOL_NAME = '1.21.5';

    const PACKETS = [
        ServerState::HANDSHAKE->value => [
            0x00 => HandshakePacket::class,
        ],
        ServerState::STATUS->value => [
            0x00 => StatusRequestPacket::class,
            0x01 => PingPacket::class,
        ],
        ServerState::LOGIN->value => [
            0x00 => LoginStartPacket::class,
            0x03 => LoginAcknowledgedPacket::class,
        ],
        ServerState::CONFIGURATION->value => [
            0x00 => ClientInformationPacket::class,
            0x02 => PluginMessagePacket::class,
            0x03 => AcknowledgeFinishConfigurationPacket::class,
            0x07 => KnownPacksPacket::class,
        ],
        ServerState::PLAY->value => [
            0x00 => ConfirmTeleportationPacket::class,
            0x0B => ClientTickEndPacket::class,
            0x0C => ClientInformationPacket::class,
            0x11 => ContainerClosePacket::class,
            0x1D => MovePlayerPositionRotationPacket::class,
            0x1C => MovePlayerPositionPacket::class,
            0x22 => PickItemFromBlockPacket::class,
            0x2A => PlayerLoadedPacket::class,
            0x3B => SwingPacket::class,
            0x28 => PlayerCommandPacket::class,
            0x29 => PlayerInputPacket::class,
            0x27 => PlayerActionPacket::class,
            0x1E => MovePlayerRotationPacket::class,
            0x26 => PlayerAbilitiesPacket::class,
            0x1A => KeepAlivePacket::class,
            0x1F => MovePlayerStatusOnlyPacket::class,
            0x14 => CustomPlayLoadPacket::class,
            0x33 => SetCarriedItemPacket::class,
            0x36 => SetCreativeModeSlotPacket::class,
            0x3E => UseItemOnPacket::class,
        ],
    ];
}