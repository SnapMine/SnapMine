<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\AcknowledgeFinishConfigurationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\ClientInformationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\KnownPacksPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\PluginMessagePacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Handshaking\HandshakePacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Login\EncryptionResponsePacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Login\LoginAcknowledgedPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Login\LoginStartPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\ClientTickEndPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\ConfirmTeleportationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\MovePlayerPositionPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\MovePlayerPositionRotationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\MovePlayerRotationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\PlayerActionPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\PlayerInputPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\PlayerLoadedPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Play\SwingPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Status\PingPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Status\StatusRequestPacket;

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
            0x01 => EncryptionResponsePacket::class,
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
            0x1D => MovePlayerPositionRotationPacket::class,
            0x1C => MovePlayerPositionPacket::class,
            0x2A => PlayerLoadedPacket::class,
            0x3B => SwingPacket::class,
            0x29 => PlayerInputPacket::class,
            0x27 => PlayerActionPacket::class,
            0x1E => MovePlayerRotationPacket::class,
            0x26 => PlayerAbilitiesPacket::class,
        ],
    ];
}