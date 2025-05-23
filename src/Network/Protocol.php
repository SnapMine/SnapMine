<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Packet\Configuration\PluginMessagePacket;
use Nirbose\PhpMcServ\Packet\LoginSuccessPacket;
use Nirbose\PhpMcServ\Packet\Status\PongPacket;
use Nirbose\PhpMcServ\Packet\Status\StatusResponsePacket;

class Protocol
{
    const PROTOCOL_VERSION = 770;
    const PROTOCOL_NAME = '1.21.5';

    const PACKETS = [
        ServerState::STATUS->value => [
            0x00 => StatusResponsePacket::class,
            0x01 => PongPacket::class,
        ],
        ServerState::LOGIN->value => [
            0x00 => LoginSuccessPacket::class,
        ],
        ServerState::CONFIGURATION->value => [
            0x02 => PluginMessagePacket::class,
        ],
        ServerState::PLAY->value => [],
    ];

    public static function getProtocolVersion(): int
    {
        return self::PROTOCOL_VERSION;
    }

    public static function getProtocolName(): string
    {
        return self::PROTOCOL_NAME;
    }
}