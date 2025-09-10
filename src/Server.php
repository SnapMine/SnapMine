<?php

namespace SnapMine;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use SnapMine\Block\BlockStateLoader;
use SnapMine\Command\CommandManager;
use SnapMine\Entity\Entity;
use SnapMine\Entity\EntityType;
use SnapMine\Entity\Player;
use SnapMine\Event\Event;
use SnapMine\Event\EventBinding;
use SnapMine\Event\EventManager;
use SnapMine\Event\Listener;
use SnapMine\Listener\PlayerJoinListener;
use SnapMine\Manager\ChunkManager\ChunkManager;
use SnapMine\Manager\KeepAliveManager;
use SnapMine\Network\Packet\Clientbound\Play\LevelParticles;
use SnapMine\Network\Packet\Clientbound\Play\PlayerInfoRemovePacket;
use SnapMine\Network\Packet\Clientbound\Play\RemoveEntitiesPacket;
use SnapMine\Network\Packet\Packet;
use SnapMine\Particle\Particle;
use SnapMine\Registry\Registry;
use SnapMine\Session\Session;
use SnapMine\World\Location;
use SnapMine\World\World;
use React\EventLoop\Loop;
use React\Socket\ConnectionInterface;
use React\Socket\SocketServer;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Throwable;
use function React\Async\async;

/**
 * Main server class that handles the Minecraft server implementation.
 * 
 * This class is the core of the SnapMine server, managing all aspects of
 * server operation including network connections, player management,
 * world loading, event handling, and game mechanics.
 * 
 * The server uses ReactPHP for asynchronous networking and supports
 * multiple worlds, custom events, and plugin-like listeners.
 * 
 * @package SnapMine
 * @author  Nirbose
 * @since   1.0.0
 * 
 * @example
 * ```php
 * $server = new Server('127.0.0.1', 25565);
 * $server->start(); // Starts the server and begins accepting connections
 * ```
 */
class Server
{
    /** Current server version identifier */
    public const VERSION = 'v0.0.1-dev';

    /**
     * ReactPHP socket server for handling network connections.
     * 
     * @var SocketServer
     */
    private SocketServer $socket;
    
    /**
     * Array of active client connections.
     * 
     * @var ConnectionInterface[]
     */
    private array $clients = [];
    
    /**
     * Array of active player sessions mapped by connection ID.
     * 
     * @var array<int, Session>
     */
    private array $sessions = [];
    
    /**
     * Array of connected players mapped by UUID.
     * 
     * @var array<string, Player>
     */
    private array $players = [];
    
    /**
     * Event manager for handling custom events and listeners.
     * 
     * @var EventManager
     */
    private EventManager $eventManager;
    
    /**
     * Counter for generating unique entity IDs.
     * 
     * @var int
     */
    private int $entityIdCounter = 0;

    /**
     * Static logger instance for server-wide logging.
     * 
     * @var Logger|null
     */
    private static Logger|null $logger = null;
    
    /**
     * Log message format string.
     * 
     * @var string
     */
    private static string $logFormat = "[%datetime%] %level_name%: %message%\n";
    
    /**
     * Array of loaded worlds mapped by world name.
     * 
     * @var array<string, World>
     */
    private array $worlds = [];
    
    /**
     * Maximum number of players allowed on the server.
     * 
     * @var int
     */
    private int $maxPlayer = 20;
    
    /**
     * Block state loader for handling block data.
     * 
     * @var BlockStateLoader
     */
    private BlockStateLoader $blockStateLoader;
    
    /**
     * Chunk manager for world chunk operations.
     * 
     * @var ChunkManager
     */
    private ChunkManager $chunkManager;
    
    /**
     * Server configuration handler.
     * 
     * @var ServerConfig
     */
    private ServerConfig $config;
    
    /**
     * Command manager for handling chat commands.
     * 
     * @var CommandManager
     */
    private CommandManager $commandManager;

    /**
     * Create a new server instance.
     * 
     * @param string|null $host The host address to bind to (defaults to config value)
     * @param int|null    $port The port to bind to (defaults to config value)
     * 
     * @throws Exception If configuration loading fails
     */
    public function __construct(
        private ?string $host = null,
        private ?int    $port = null,
    )
    {
        Artisan::setServer($this);

        $this->eventManager = new EventManager();
        $this->blockStateLoader = new BlockStateLoader(__DIR__ . '/../resources/blocks.json');
        $this->config = new ServerConfig(dirname(__DIR__) . "/config.yml");

        if ($this->host === null) {
            $this->host = $this->config->get('host');

            if ($this->host == 'localhost') {
                $this->host = '127.0.0.1';
            }
        }

        if ($this->port === null) {
            $this->port = $this->config->get('port');
        }

        Registry::load(dirname(__DIR__) . '/resources/registries/');
        $this->chunkManager = new ChunkManager();
        $this->commandManager = new CommandManager();

        foreach (glob(dirname(__DIR__) . '/resources/worlds/*/') as $folder) {
            $this->worlds[basename($folder)] = new World($folder);
        }
    }

    /**
     * Server destructor - clean up resources when server shuts down.
     * 
     * Closes all client connections, shuts down the socket server,
     * and cleans up server state.
     */
    public function __destruct()
    {
        foreach ($this->clients as $client) {
            try { $client->close(); } catch (Throwable) {}
        }

        if (isset($this->socket)) {
            try { $this->socket->close(); } catch (Throwable) {}
        }

        $this->clients = [];
        $this->sessions = [];
        $this->players = [];
        self::getLogger()->info("Server stopped.");
    }

    /**
     * Start the server and begin accepting connections.
     * 
     * This method initializes the ReactPHP event loop, creates the socket server,
     * registers default listeners, and starts the main server loop. The method
     * blocks until the server is stopped.
     * 
     * @return void
     * 
     * @throws Exception If server startup fails
     */
    public function start(): void
    {
        $loop = Loop::get();

        $this->socket = new SocketServer("{$this->host}:{$this->port}", [], $loop);
        self::getLogger()->info("Serveur démarré sur {$this->host}:{$this->port}");

        $this->registerListener(new PlayerJoinListener());

        $keepAliveManager = new KeepAliveManager();
        // Tick keep-alives periodically
        $loop->addPeriodicTimer(1.0, function () use ($keepAliveManager) {
            $keepAliveManager->tick($this);
        });

        // Handle new connections
        $this->socket->on('connection', function (ConnectionInterface $connection) {
            $this->clients[] = $connection;
            $id = spl_object_id($connection);
            $this->sessions[$id] = new Session($this, $connection);
            echo "Nouveau client connecté.\n";

            $connection->on('data', function (string $data) use ($id) {
                if (!isset($this->sessions[$id])) {
                    return;
                }

                /** @var Session $session */
                $session = $this->sessions[$id];
                $session->serializer->put($data);
                async(function () use ($session) {$session->handle();})();
            });

            $connection->on('close', function () use ($id, $connection) {
                if (!isset($this->sessions[$id])) {
                    return;
                }

                /** @var Session $session */
                $session = $this->sessions[$id];
                $this->closeSession($session, $connection);
            });
        });

        // Run the loop until stopped
        $loop->run();
    }

    /**
     * Close a player session and clean up associated resources.
     * 
     * @param Session             $session The session to close
     * @param ConnectionInterface $socket  The socket connection to close
     * @return void
     */
    public function closeSession(Session $session, ConnectionInterface $socket): void
    {
        try {
            $id = spl_object_id($socket);

            if ($session->getPlayer() !== null) {
                if (isset($this->players[$session->getPlayer()->getUuid()->toString()])) {
                    unset($this->players[$session->getPlayer()->getUuid()->toString()]);
                }

                $this->broadcastPacket(new PlayerInfoRemovePacket([$session->getPlayer()->getUuid()]));
                $this->broadcastPacket(new RemoveEntitiesPacket([$session->getPlayer()]));
            }

            // Remove from clients list
            $key = array_search($socket, $this->clients, true);
            if ($key !== false) {
                unset($this->clients[$key]);
                // reindex array
                $this->clients = array_values($this->clients);
            }

            unset($this->sessions[$id]);
            try { $socket->close(); } catch (Throwable) {}
        } catch (Exception) {
        }
    }

    /**
     * Increment and get the next available entity ID.
     * 
     * @return int The next unique entity ID
     */
    public function incrementAndGetId(): int
    {
        return $this->entityIdCounter++;
    }

    /**
     * Get a world by name.
     * 
     * @param string $name The world name
     * @return World|null The world instance, or null if not found
     */
    public function getWorld(string $name): ?World
    {
        return $this->worlds[$name] ?? null;
    }

    /**
     * Get all loaded worlds.
     * 
     * @return array<string, World> Array of worlds mapped by name
     */
    public function getWorlds(): array
    {
        return $this->worlds;
    }

    /**
     * Get the chunk manager instance.
     * 
     * @return ChunkManager The chunk manager
     */
    public function getChunkManager(): ChunkManager
    {
        return $this->chunkManager;
    }

    /**
     * Get the static logger instance.
     * 
     * Creates and configures the logger if it doesn't exist yet.
     * 
     * @return Logger The configured logger instance
     */
    public static function getLogger(): Logger
    {
        if (self::$logger === null) {
            $formatter = new LineFormatter(self::$logFormat, 'Y-m-d H:i:s');
            self::$logger = new Logger('server');
            $handler = new StreamHandler('php://stdout', Level::Debug);

            $handler->setFormatter($formatter);
            self::$logger->pushHandler($handler);
        }

        return self::$logger;
    }

    /**
     * Add a new player to the server.
     * 
     * @param Player $player The player to add
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        $this->players[$player->getUuid()->toString()] = $player;
    }

    /**
     * Get all connected players.
     * 
     * @return array<string, Player> Array of players mapped by UUID
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Get a player by their UUID.
     * 
     * @param string $uuid The player's UUID string
     * @return Player|null The player instance, or null if not found
     */
    public function getPlayerByUUID(string $uuid): ?Player
    {
        return $this->players[$uuid] ?? null;
    }

    /**
     * Register an event listener with the server.
     * 
     * Uses reflection to automatically discover and register event handler methods
     * based on the EventBinding attribute and method parameters.
     * 
     * @param Listener $listener The listener instance to register
     * @return void
     * 
     * @throws Exception If listener registration fails
     */
    public function registerListener(Listener $listener): void
    {
        $reflexionClass = new ReflectionClass($listener);

        foreach ($reflexionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $attributes = $method->getAttributes(EventBinding::class);

            if (empty($attributes)) {
                continue;
            }

            $parameters = $method->getParameters();

            if (count($parameters) > 1) {
                throw new Exception("Require one parameter"); // TODO: Change exception
            }

            $type = $parameters[0]->getType();

            if ($type instanceof ReflectionNamedType) {
                $isEventChild = get_parent_class($type->getName()) === Event::class;

                if (!$isEventChild) {
                    throw new Exception("Parameter is not instance of Event"); // TODO: Change exception
                }

                $this->eventManager->register($type->getName(), $method->getClosure($listener));
            }
        }
    }

    /**
     * Get the maximum number of players allowed on the server.
     * 
     * @return int The maximum player count
     */
    public function getMaxPlayer(): int
    {
        return $this->config->get('max-player');
    }

    /**
     * Set the maximum number of players allowed on the server.
     * 
     * @param int $maxPlayer The new maximum player count
     * @return void
     */
    public function setMaxPlayer(int $maxPlayer): void
    {
        $this->config->set('max-player', $maxPlayer);
    }

    /**
     * Broadcast a packet to all connected players.
     * 
     * @param Packet        $packet The packet to broadcast
     * @param callable|null $filter Optional filter function to determine which players receive the packet
     * @return void
     */
    public function broadcastPacket(Packet $packet, ?callable $filter = null): void
    {
        foreach ($this->players as $player) {
            if (is_null($filter) || $filter($player)) {
                $player->sendPacket($packet);
            }
        }
    }

    /**
     * Spawn a new entity in the world.
     * 
     * @param EntityType    $entityType The type of entity to spawn
     * @param Location|null $location   The location to spawn at (defaults to world spawn)
     * @return Entity The spawned entity instance
     */
    public function spawnEntity(EntityType $entityType, ?Location $location = null): Entity
    {
        if (is_null($location)) {
            $location = new Location($this->worlds['world'], 0, 0, 0);
        }

        return $location->getWorld()->spawnEntity($entityType, $location);
    }

    /**
     * Get the block state loader instance.
     * 
     * @return BlockStateLoader The block state loader
     */
    public function getBlockStateLoader(): BlockStateLoader
    {
        return $this->blockStateLoader;
    }

    /**
     * Spawn a particle effect at the specified coordinates.
     * 
     * @param Particle    $particle The particle type to spawn
     * @param float       $x        X coordinate
     * @param float       $y        Y coordinate  
     * @param float       $z        Z coordinate
     * @param object|null $data     Optional particle-specific data
     * @return void
     * 
     * @throws Exception If particle requires data but none is provided
     */
    public function spawnParticle(Particle $particle, float $x, float $y, float $z, ?object $data = null): void
    {
        $dataClass = $particle->getDataClass();

        if ($data === null && $dataClass !== null) {
            throw new Exception("error");
        }

        $this->broadcastPacket(new LevelParticles($particle, 1, $x, $y, $z, 0, 0, 0, 0, true, false, $data));
    }

    /**
     * Get the server configuration instance.
     * 
     * @return ServerConfig The server configuration
     */
    public function getConfig(): ServerConfig
    {
        return $this->config;
    }

    /**
     * Get the command manager instance.
     * 
     * @return CommandManager The command manager
     */
    public function getCommandManager(): CommandManager
    {
        return $this->commandManager;
    }
}
