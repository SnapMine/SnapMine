<?php

namespace Nirbose\PhpMcServ;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\World\Region;

class Artisan
{
    private static ?Server $server = null;

    public static function setServer(Server $server): void
    {
        self::$server = $server;
    }

    /**
     * @return Server|null
     */
    public static function getServer(): ?Server
    {
        return self::$server;
    }

    public static function getPlayers(): array
    {
        return self::$server->getPlayers();
    }

    public static function getBlockStateLoader(): BlockStateLoader
    {
        return self::$server->getBlockStateLoader();
    }
}