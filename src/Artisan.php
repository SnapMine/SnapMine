<?php

namespace Nirbose\PhpMcServ;

class Artisan
{
    private static ?Server $server = null;

    public static function setServer(Server $server): void
    {
        self::$server = $server;
    }

    public static function getPlayers(): array
    {
        return self::$server->getPlayers();
    }
}