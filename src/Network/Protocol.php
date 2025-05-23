<?php

namespace Nirbose\PhpMcServ\Network;

use Nirbose\PhpMcServ\Packet\Status\PongPacket;
use Nirbose\PhpMcServ\Packet\Status\StatusResponsePacket;

class Protocol
{
    const PROTOCOL_VERSION = 770;
    const PROTOCOL_NAME = '1.21.5';

    const PACKETS = [
        'status' => [
            0x00 => StatusResponsePacket::class,
            0x01 => PongPacket::class,
        ],
        'login' => [
            0x00 => \Nirbose\PhpMcServ\Packet\LoginStartPacket::class,
            0x02 => \Nirbose\PhpMcServ\Packet\LoginSuccessPacket::class,
        ],
        'play' => [],
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