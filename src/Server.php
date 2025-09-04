<?php

namespace SnapMine;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use React\EventLoop\Loop;
use Revolt\EventLoop;
use SnapMine\Block\BlockStateLoader;
use SnapMine\Command\CommandExecutor;
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
use React\Socket\ConnectionInterface;
use React\Socket\SocketServer;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Throwable;

class Server
{
    private SocketServer $socket;
    /** @var ConnectionInterface[] */
    private array $clients = [];
    private array $sessions = [];
    private array $players = [];
    private EventManager $eventManager;
    private int $entityIdCounter = 0;

    private static Logger|null $logger = null;
    private static string $logFormat = "[%datetime%] %level_name%: %message%\n";
    /** @var World[] */
    private array $worlds = [];
    private int $maxPlayer = 20;
    private BlockStateLoader $blockStateLoader;
    private ChunkManager $chunkManager;
    private ServerConfig $config;
    private CommandManager $commandManager;

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

    public function start(): void
    {
        $this->socket = new SocketServer("{$this->host}:{$this->port}", [], Loop::get());
        self::getLogger()->info("Serveur démarré sur {$this->host}:{$this->port}");

        $this->registerListener(new PlayerJoinListener());

        $keepAliveManager = new KeepAliveManager();
        // Tick keep-alives periodically
        EventLoop::repeat(1, function () use ($keepAliveManager) {
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
                $session->handle();
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

        EventLoop::run();
    }

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

    public function incrementAndGetId(): int
    {
        return $this->entityIdCounter++;
    }

    public function getWorld(string $name): ?World
    {
        return $this->worlds[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getWorlds(): array
    {
        return $this->worlds;
    }

    public function getChunkManager(): ChunkManager
    {
        return $this->chunkManager;
    }

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
     * Add new player
     *
     * @param Player $player
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        $this->players[$player->getUuid()->toString()] = $player;
    }

    /**
     * Get all players connected to the server.
     *
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayerByUUID(string $uuid): ?Player
    {
        return $this->players[$uuid] ?? null;
    }

    /**
     * Register listener
     *
     * @param Listener $listener
     * @return void
     * @throws Exception
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
     * @return int
     */
    public function getMaxPlayer(): int
    {
        return $this->config->get('max-player');
    }

    /**
     * @param int $maxPlayer
     */
    public function setMaxPlayer(int $maxPlayer): void
    {
        $this->config->set('max-player', $maxPlayer);
    }

    /**
     * Broadcast packet for all players
     * @param Packet $packet
     * @param callable|null $filter
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
     * Spawn new entity
     * @param EntityType $entityType
     * @param Location|null $location
     * @return Entity
     */
    public function spawnEntity(EntityType $entityType, ?Location $location = null): Entity
    {
        if (is_null($location)) {
            $location = new Location($this->worlds['world'], 0, 0, 0);
        }

        return $location->getWorld()->spawnEntity($entityType, $location);
    }

    /**
     * @return BlockStateLoader
     */
    public function getBlockStateLoader(): BlockStateLoader
    {
        return $this->blockStateLoader;
    }

    public function spawnParticle(Particle $particle, float $x, float $y, float $z, ?object $data = null): void
    {
        $dataClass = $particle->getDataClass();

        if ($data === null && $dataClass !== null) {
            throw new Exception("error");
        }

        $this->broadcastPacket(new LevelParticles($particle, 1, $x, $y, $z, 0, 0, 0, 0, true, false, $data));
    }

    /**
     * @return ServerConfig
     */
    public function getConfig(): ServerConfig
    {
        return $this->config;
    }

    /**
     * @return CommandManager
     */
    public function getCommandManager(): CommandManager
    {
        return $this->commandManager;
    }

    public function registerCommand(string $name, CommandExecutor $executor): void
    {
        $this->commandManager->add($name, $executor);
    }
}
