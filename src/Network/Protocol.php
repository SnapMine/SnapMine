<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Packet\Serverbound\Handshaking\HandshakePacket;
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
        ],
        ServerState::CONFIGURATION->value => [],
        ServerState::PLAY->value => [],
    ];
}