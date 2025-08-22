<?php

namespace Nirbose\PhpMcServ;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Entity\AreaEffectCloud;
use Nirbose\PhpMcServ\Entity\Cow;
use Nirbose\PhpMcServ\Entity\DragonFireball;
use Nirbose\PhpMcServ\Entity\EndCrystal;
use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\EvokerFangs;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Entity\Sheep;
use Nirbose\PhpMcServ\Entity\WindCharge;
use Nirbose\PhpMcServ\Event\Event;
use Nirbose\PhpMcServ\Event\EventBinding;
use Nirbose\PhpMcServ\Event\EventManager;
use Nirbose\PhpMcServ\Event\Listener;
use Nirbose\PhpMcServ\Listener\PlayerJoinListener;
use Nirbose\PhpMcServ\Manager\KeepAliveManager;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AddEntityPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\LevelParticles;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Particle\Particle;
use Nirbose\PhpMcServ\Registry\Registry;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Chunk\Chunk;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Region;
use Nirbose\PhpMcServ\World\World;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Socket;
use Throwable;

class Server
{
    private Socket $socket;
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

    public function __construct(
        private readonly string $host,
        private readonly int    $port,
    )
    {
        $this->eventManager = new EventManager();
        $this->blockStateLoader = new BlockStateLoader(__DIR__ . '/../resources/blocks.json');
        Registry::load(dirname(__DIR__) . '/resources/registries/');

        foreach (glob(dirname(__DIR__) . '/resources/worlds/*/') as $folder) {
            $this->worlds[basename($folder)] = new World($folder);
        }
    }

    public function __destruct()
    {
        foreach ($this->clients as $client) {
            if ($client instanceof Socket) {
                socket_close($client);
            }
        }

        socket_close($this->socket);

        $this->clients = [];
        $this->sessions = [];
        $this->players = [];
        self::getLogger()->info("Server stopped.");
    }

    public function start(): void
    {
        Artisan::setServer($this);

        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($this->socket, $this->host, $this->port);
        socket_listen($this->socket);
        self::getLogger()->info("Serveur démarré sur {$this->host}:{$this->port}");

        $this->registerListener(new PlayerJoinListener());

        $write = $except = null;
        $keepAliveManager = new KeepAliveManager();

        /** @phpstan-ignore while.alwaysTrue */
        while (true) {
            $keepAliveManager->tick($this);
            $read = array_merge([$this->socket], $this->clients);

            try {
                socket_select($read, $write, $except, null);
            } catch (Throwable) {
                $read = array_merge([$this->socket], $this->clients);
            }

            foreach ($read as $socket) {
                if ($socket === $this->socket) {
                    $client = socket_accept($this->socket);

                    if ($client) {
                        socket_set_nonblock($client);
                        $this->clients[] = $client;
                        $this->sessions[spl_object_id($client)] = new Session($this, $client);
                        echo "Nouveau client connecté.\n";
                    }
                } else {
                    $id = spl_object_id($socket);

                    if (!isset($this->sessions[$id])) {
                        $key = array_search($socket, $this->clients, true);
                        if ($key !== false) {
                            unset($this->clients[$key]);
                        }
                        continue;
                    }

                    $data = @socket_read($socket, 2048);

                    if ($data === '' || $data === false) {
                        $this->clients = array_values($this->clients);
                        $this->sessions[$id]->close();
                        continue;
                    }

                    if (!isset($this->sessions[$id])) continue;

                    /** @var Session $session */
                    $session = $this->sessions[$id];
                    $session->serializer->put($data);

//                     echo "Paquet brut reçu (hex) : " . bin2hex($data) . "\n";

                    $session->handle();
                }
            }
        }
    }

    public function closeSession(Session $session, Socket $socket): void
    {
        try {
            $id = spl_object_id($socket);

            unset($this->clients[$id]);

            if ($session->getPlayer() !== null) {
                if (isset($this->players[$session->getPlayer()->getUuid()->toString()])) {
                    unset($this->players[$session->getPlayer()->getUuid()->toString()]);
                }
            }

            unset($this->sessions[$id]);

            socket_close($socket);
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
        return $this->maxPlayer;
    }

    /**
     * @param int $maxPlayer
     */
    public function setMaxPlayer(int $maxPlayer): void
    {
        $this->maxPlayer = $maxPlayer;
    }

    /**
     * Broadcast packet for all players
     * @param Packet $packet
     */
    public function broadcastPacket(Packet $packet): void
    {
        foreach ($this->players as $player) {
            $player->sendPacket($packet);
        }
    }

    /**
     * Spawn new entity
     * @param EntityType $entityType
     * @return Entity
     */
    public function spawnEntity(EntityType $entityType, Location $location = new Location(0, 0, 0)): Entity
    {
        $entity = match ($entityType) {
            EntityType::ACACIA_BOAT => throw new \Exception('To be implemented'),
            EntityType::ACACIA_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::ALLAY => throw new \Exception('To be implemented'),
            EntityType::AREA_EFFECT_CLOUD => new AreaEffectCloud($this, $location),
            EntityType::ARMADILLO => throw new \Exception('To be implemented'),
            EntityType::ARMOR_STAND => throw new \Exception('To be implemented'),
            EntityType::ARROW => throw new \Exception('To be implemented'),
            EntityType::AXOLOTL => throw new \Exception('To be implemented'),
            EntityType::BAMBOO_CHEST_RAFT => throw new \Exception('To be implemented'),
            EntityType::BAMBOO_RAFT => throw new \Exception('To be implemented'),
            EntityType::BAT => throw new \Exception('To be implemented'),
            EntityType::BEE => throw new \Exception('To be implemented'),
            EntityType::BIRCH_BOAT => throw new \Exception('To be implemented'),
            EntityType::BIRCH_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::BLAZE => throw new \Exception('To be implemented'),
            EntityType::BLOCK_DISPLAY => throw new \Exception('To be implemented'),
            EntityType::BOGGED => throw new \Exception('To be implemented'),
            EntityType::BREEZE => throw new \Exception('To be implemented'),
            EntityType::BREEZE_WIND_CHARGE => throw new \Exception('To be implemented'),
            EntityType::CAMEL => throw new \Exception('To be implemented'),
            EntityType::CAT => throw new \Exception('To be implemented'),
            EntityType::CAVE_SPIDER => throw new \Exception('To be implemented'),
            EntityType::CHERRY_BOAT => throw new \Exception('To be implemented'),
            EntityType::CHERRY_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::CHEST_MINECART => throw new \Exception('To be implemented'),
            EntityType::CHICKEN => throw new \Exception('To be implemented'),
            EntityType::COD => throw new \Exception('To be implemented'),
            EntityType::COMMAND_BLOCK_MINECART => throw new \Exception('To be implemented'),
            EntityType::COW => new Cow($this, $location),
            EntityType::CREAKING => throw new \Exception('To be implemented'),
            EntityType::CREEPER => throw new \Exception('To be implemented'),
            EntityType::DARK_OAK_BOAT => throw new \Exception('To be implemented'),
            EntityType::DARK_OAK_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::DOLPHIN => throw new \Exception('To be implemented'),
            EntityType::DONKEY => throw new \Exception('To be implemented'),
            EntityType::DRAGON_FIREBALL => new DragonFireball($this, $location),
            EntityType::DROWNED => throw new \Exception('To be implemented'),
            EntityType::EGG => throw new \Exception('To be implemented'),
            EntityType::ELDER_GUARDIAN => throw new \Exception('To be implemented'),
            EntityType::END_CRYSTAL => new EndCrystal($this, $location),
            EntityType::ENDER_DRAGON => throw new \Exception('To be implemented'),
            EntityType::ENDER_PEARL => throw new \Exception('To be implemented'),
            EntityType::ENDERMAN => throw new \Exception('To be implemented'),
            EntityType::ENDERMITE => throw new \Exception('To be implemented'),
            EntityType::EVOKER => throw new \Exception('To be implemented'),
            EntityType::EVOKER_FANGS => new EvokerFangs($this, $location),
            EntityType::EXPERIENCE_BOTTLE => throw new \Exception('To be implemented'),
            EntityType::EXPERIENCE_ORB => throw new \Exception('To be implemented'),
            EntityType::EYE_OF_ENDER => throw new \Exception('To be implemented'),
            EntityType::FALLING_BLOCK => throw new \Exception('To be implemented'),
            EntityType::FIREBALL => throw new \Exception('To be implemented'),
            EntityType::FIREWORK_ROCKET => throw new \Exception('To be implemented'),
            EntityType::FISHING_BOBBER => throw new \Exception('To be implemented'),
            EntityType::FOX => throw new \Exception('To be implemented'),
            EntityType::FROG => throw new \Exception('To be implemented'),
            EntityType::FURNACE_MINECART => throw new \Exception('To be implemented'),
            EntityType::GHAST => throw new \Exception('To be implemented'),
            EntityType::GIANT => throw new \Exception('To be implemented'),
            EntityType::GLOW_ITEM_FRAME => throw new \Exception('To be implemented'),
            EntityType::GLOW_SQUID => throw new \Exception('To be implemented'),
            EntityType::GOAT => throw new \Exception('To be implemented'),
            EntityType::GUARDIAN => throw new \Exception('To be implemented'),
            EntityType::HOGLIN => throw new \Exception('To be implemented'),
            EntityType::HOPPER_MINECART => throw new \Exception('To be implemented'),
            EntityType::HORSE => throw new \Exception('To be implemented'),
            EntityType::HUSK => throw new \Exception('To be implemented'),
            EntityType::ILLUSIONER => throw new \Exception('To be implemented'),
            EntityType::INTERACTION => throw new \Exception('To be implemented'),
            EntityType::IRON_GOLEM => throw new \Exception('To be implemented'),
            EntityType::ITEM => throw new \Exception('To be implemented'),
            EntityType::ITEM_DISPLAY => throw new \Exception('To be implemented'),
            EntityType::ITEM_FRAME => throw new \Exception('To be implemented'),
            EntityType::JUNGLE_BOAT => throw new \Exception('To be implemented'),
            EntityType::JUNGLE_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::LEASH_KNOT => throw new \Exception('To be implemented'),
            EntityType::LIGHTNING_BOLT => throw new \Exception('To be implemented'),
            EntityType::LINGERING_POTION => throw new \Exception('To be implemented'),
            EntityType::LLAMA => throw new \Exception('To be implemented'),
            EntityType::LLAMA_SPIT => throw new \Exception('To be implemented'),
            EntityType::MAGMA_CUBE => throw new \Exception('To be implemented'),
            EntityType::MANGROVE_BOAT => throw new \Exception('To be implemented'),
            EntityType::MANGROVE_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::MARKER => throw new \Exception('To be implemented'),
            EntityType::MINECART => throw new \Exception('To be implemented'),
            EntityType::MOOSHROOM => throw new \Exception('To be implemented'),
            EntityType::MULE => throw new \Exception('To be implemented'),
            EntityType::OAK_BOAT => throw new \Exception('To be implemented'),
            EntityType::OAK_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::OCELOT => throw new \Exception('To be implemented'),
            EntityType::OMINOUS_ITEM_SPAWNER => throw new \Exception('To be implemented'),
            EntityType::PAINTING => throw new \Exception('To be implemented'),
            EntityType::PALE_OAK_BOAT => throw new \Exception('To be implemented'),
            EntityType::PALE_OAK_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::PANDA => throw new \Exception('To be implemented'),
            EntityType::PARROT => throw new \Exception('To be implemented'),
            EntityType::PHANTOM => throw new \Exception('To be implemented'),
            EntityType::PIG => throw new \Exception('To be implemented'),
            EntityType::PIGLIN => throw new \Exception('To be implemented'),
            EntityType::PIGLIN_BRUTE => throw new \Exception('To be implemented'),
            EntityType::PILLAGER => throw new \Exception('To be implemented'),
            EntityType::PLAYER => throw new \Exception('To be implemented'),
            EntityType::POLAR_BEAR => throw new \Exception('To be implemented'),
            EntityType::PUFFERFISH => throw new \Exception('To be implemented'),
            EntityType::RABBIT => throw new \Exception('To be implemented'),
            EntityType::RAVAGER => throw new \Exception('To be implemented'),
            EntityType::SALMON => throw new \Exception('To be implemented'),
            EntityType::SHEEP => new Sheep($this, $location),
            EntityType::SHULKER => throw new \Exception('To be implemented'),
            EntityType::SHULKER_BULLET => throw new \Exception('To be implemented'),
            EntityType::SILVERFISH => throw new \Exception('To be implemented'),
            EntityType::SKELETON => throw new \Exception('To be implemented'),
            EntityType::SKELETON_HORSE => throw new \Exception('To be implemented'),
            EntityType::SLIME => throw new \Exception('To be implemented'),
            EntityType::SMALL_FIREBALL => throw new \Exception('To be implemented'),
            EntityType::SNIFFER => throw new \Exception('To be implemented'),
            EntityType::SNOW_GOLEM => throw new \Exception('To be implemented'),
            EntityType::SNOWBALL => throw new \Exception('To be implemented'),
            EntityType::SPAWNER_MINECART => throw new \Exception('To be implemented'),
            EntityType::SPECTRAL_ARROW => throw new \Exception('To be implemented'),
            EntityType::SPIDER => throw new \Exception('To be implemented'),
            EntityType::SPLASH_POTION => throw new \Exception('To be implemented'),
            EntityType::SPRUCE_BOAT => throw new \Exception('To be implemented'),
            EntityType::SPRUCE_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::SQUID => throw new \Exception('To be implemented'),
            EntityType::STRAY => throw new \Exception('To be implemented'),
            EntityType::STRIDER => throw new \Exception('To be implemented'),
            EntityType::TADPOLE => throw new \Exception('To be implemented'),
            EntityType::TEXT_DISPLAY => throw new \Exception('To be implemented'),
            EntityType::TNT => throw new \Exception('To be implemented'),
            EntityType::TNT_MINECART => throw new \Exception('To be implemented'),
            EntityType::TRADER_LLAMA => throw new \Exception('To be implemented'),
            EntityType::TRIDENT => throw new \Exception('To be implemented'),
            EntityType::TROPICAL_FISH => throw new \Exception('To be implemented'),
            EntityType::TURTLE => throw new \Exception('To be implemented'),
            EntityType::VEX => throw new \Exception('To be implemented'),
            EntityType::VILLAGER => throw new \Exception('To be implemented'),
            EntityType::VINDICATOR => throw new \Exception('To be implemented'),
            EntityType::WANDERING_TRADER => throw new \Exception('To be implemented'),
            EntityType::WARDEN => throw new \Exception('To be implemented'),
            EntityType::WIND_CHARGE => new WindCharge($this, $location),
            EntityType::WITCH => throw new \Exception('To be implemented'),
            EntityType::WITHER => throw new \Exception('To be implemented'),
            EntityType::WITHER_SKELETON => throw new \Exception('To be implemented'),
            EntityType::WITHER_SKULL => throw new \Exception('To be implemented'),
            EntityType::WOLF => throw new \Exception('To be implemented'),
            EntityType::ZOGLIN => throw new \Exception('To be implemented'),
            EntityType::ZOMBIE => throw new \Exception('To be implemented'),
            EntityType::ZOMBIE_HORSE => throw new \Exception('To be implemented'),
            EntityType::ZOMBIE_VILLAGER => throw new \Exception('To be implemented'),
            EntityType::ZOMBIFIED_PIGLIN => throw new \Exception('To be implemented'),
        };

        $this->broadcastPacket(new AddEntityPacket($entity, 0, 0, 0, 0));

        return $entity;
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
}