<?php

namespace SnapMine;

use Monolog\Logger;
use SnapMine\Block\BlockStateLoader;
use SnapMine\Command\CommandManager;
use SnapMine\World\Region;

/**
 * Static utility class providing global access to server components.
 * 
 * The Artisan class serves as a service locator pattern implementation,
 * providing static access to commonly used server components without
 * requiring dependency injection. This is useful for accessing server
 * functionality from anywhere in the codebase.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * // Get the server instance
 * $server = Artisan::getServer();
 * 
 * // Get all connected players
 * $players = Artisan::getPlayers();
 * 
 * // Access the logger
 * Artisan::getLogger()->info('Something happened');
 * ```
 */
class Artisan
{
    /**
     * Static reference to the server instance.
     * 
     * @var Server|null
     */
    private static ?Server $server = null;

    /**
     * Set the server instance for global access.
     * 
     * This method should be called once during server initialization
     * to make the server instance available through static methods.
     * 
     * @param Server $server The server instance to set
     * @return void
     */
    public static function setServer(Server $server): void
    {
        self::$server = $server;
    }

    /**
     * Get the server instance.
     * 
     * @return Server|null The server instance, or null if not set
     */
    public static function getServer(): ?Server
    {
        return self::$server;
    }

    /**
     * Get the server logger instance.
     * 
     * @return Logger|null The logger instance, or null if server not set
     */
    public static function getLogger(): ?Logger
    {
        return self::$server?->getLogger();
    }

    /**
     * Get all connected players.
     * 
     * @return array<string, \SnapMine\Entity\Player> Array of players mapped by UUID
     * 
     * @throws \Error If server is not set
     */
    public static function getPlayers(): array
    {
        return self::$server->getPlayers();
    }

    /**
     * Get the block state loader instance.
     * 
     * @return BlockStateLoader The block state loader
     * 
     * @throws \Error If server is not set
     */
    public static function getBlockStateLoader(): BlockStateLoader
    {
        return self::$server->getBlockStateLoader();
    }

    /**
     * Get the command manager instance.
     * 
     * @return CommandManager The command manager
     * 
     * @throws \Error If server is not set
     */
    public static function getCommandManager(): CommandManager
    {
        return self::$server->getCommandManager();
    }
}