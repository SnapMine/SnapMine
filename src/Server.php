<?php

namespace Nirbose\PhpMcServ;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Nirbose\PhpMcServ\Session\Session;

class Server
{
    private string $host;
    private int $port;
    private $socket;
    private array $clients = [];
    private array $sessions = [];

    private static Logger|null $logger = null;
    private static string $logFormat = "[%datetime%] %level_name%: %message%\n";

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function start(): void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($this->socket, $this->host, $this->port);
        socket_listen($this->socket);
        self::getLogger()->info("Serveur démarré sur {$this->host}:{$this->port}");

        $write = $except = null;

        while (true) {
            $read = array_merge([$this->socket], $this->clients);
            socket_select($read, $write, $except, null);

            foreach ($read as $socket) {
                if ($socket === $this->socket) {
                    $client = socket_accept($this->socket);

                    if ($client) {
                        socket_set_nonblock($client);
                        $this->clients[] = $client;
                        $this->sessions[spl_object_id($client)] = new Session($client);
                        echo "Nouveau client connecté.\n";
                    }
                    continue;
                } else {
                    $data = @socket_read($socket, 2048);
                    $id = spl_object_id($socket);

                    if ($data === '' || $data === false) {
                        unset($this->clients[array_search($socket, $this->clients, true)]);
                        $this->clients = array_values($this->clients);
                        $this->sessions[$id]->close();
                        unset($this->sessions[$id]);
                        continue;
                    }

                    if (!isset($this->sessions[$id])) continue;

                    /** @var Session $session */
                    $session = $this->sessions[$id];
                    $session->buffer .= $data;

                    echo "Paquet brut reçu (hex) : " . bin2hex($data) . "\n";

                    $session->handle();
                }
            }
        }
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
}