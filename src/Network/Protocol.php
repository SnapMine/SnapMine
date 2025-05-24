<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\AcknowledgeFinishConfigurationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\ClientInformationPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\KnownPacksPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Configuration\PluginMessagePacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Handshaking\HandshakePacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Login\LoginAcknowledgedPacket;
use Nirbose\PhpMcServ\Packet\Serverbound\Login\LoginStartPacket;
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
            0x03 => LoginAcknowledgedPacket::class,
        ],
        ServerState::CONFIGURATION->value => [
            0x00 => ClientInformationPacket::class,
            0x02 => PluginMessagePacket::class,
            0x03 => AcknowledgeFinishConfigurationPacket::class,
            0x07 => KnownPacksPacket::class,
        ],
        ServerState::PLAY->value => [],
    ];
}