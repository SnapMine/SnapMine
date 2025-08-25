<?php

namespace SnapMine;

use Monolog\Logger;
use SnapMine\Block\BlockStateLoader;
use SnapMine\World\Region;

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

    public static function getLogger(): ?Logger
    {
        return self::$server?->getLogger();
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