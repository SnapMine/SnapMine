<?php

namespace SnapMine\Network;

use SnapMine\Network\Packet\Serverbound\Configuration\AcknowledgeFinishConfigurationPacket;
use SnapMine\Network\Packet\Serverbound\Configuration\ClientInformationPacket;
use SnapMine\Network\Packet\Serverbound\Configuration\KnownPacksPacket;
use SnapMine\Network\Packet\Serverbound\Configuration\PluginMessagePacket;
use SnapMine\Network\Packet\Serverbound\Handshaking\HandshakePacket;
use SnapMine\Network\Packet\Serverbound\Login\LoginAcknowledgedPacket;
use SnapMine\Network\Packet\Serverbound\Login\LoginStartPacket;
use SnapMine\Network\Packet\Serverbound\Play\ChatCommandPacket;
use SnapMine\Network\Packet\Serverbound\Play\ChatMessagePacket;
use SnapMine\Network\Packet\Serverbound\Play\ClientTickEndPacket;
use SnapMine\Network\Packet\Serverbound\Play\ConfirmTeleportationPacket;
use SnapMine\Network\Packet\Serverbound\Play\ContainerClosePacket;
use SnapMine\Network\Packet\Serverbound\Play\CustomPlayLoadPacket;
use SnapMine\Network\Packet\Serverbound\Play\KeepAlivePacket;
use SnapMine\Network\Packet\Serverbound\Play\MovePlayerPositionPacket;
use SnapMine\Network\Packet\Serverbound\Play\MovePlayerPositionRotationPacket;
use SnapMine\Network\Packet\Serverbound\Play\MovePlayerRotationPacket;
use SnapMine\Network\Packet\Serverbound\Play\MovePlayerStatusOnlyPacket;
use SnapMine\Network\Packet\Serverbound\Play\PickItemFromBlockPacket;
use SnapMine\Network\Packet\Serverbound\Play\PlayerAbilitiesPacket;
use SnapMine\Network\Packet\Serverbound\Play\PlayerActionPacket;
use SnapMine\Network\Packet\Serverbound\Play\PlayerCommandPacket;
use SnapMine\Network\Packet\Serverbound\Play\PlayerInputPacket;
use SnapMine\Network\Packet\Serverbound\Play\PlayerLoadedPacket;
use SnapMine\Network\Packet\Serverbound\Play\SetCarriedItemPacket;
use SnapMine\Network\Packet\Serverbound\Play\SetCreativeModeSlotPacket;
use SnapMine\Network\Packet\Serverbound\Play\SwingPacket;
use SnapMine\Network\Packet\Serverbound\Play\UseItemOnPacket;
use SnapMine\Network\Packet\Serverbound\Status\PingPacket;
use SnapMine\Network\Packet\Serverbound\Status\StatusRequestPacket;

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
            0x05 => ChatCommandPacket::class,
            0x07 => ChatMessagePacket::class,
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