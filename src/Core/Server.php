<?php

namespace Nirbose\PhpMcServ\Core;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Nirbose\PhpMcServ\Network\Connection;
use Nirbose\PhpMcServ\Session\PlayerSession;

class Server
{
    private string $host;
    private int $port;
    private $socket;
    private array $clients = [];

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
        socket_set_nonblock($this->socket);
        self::getLogger()->info("Serveur démarré sur {$this->host}:{$this->port}");

        while (true) {
            $client = @socket_accept($this->socket);

            if ($client !== false) {
                $connection = new Connection($client);
                $session = new PlayerSession($connection);

                $this->clients[] = $session;
            }

            /** @var PlayerSession $session */
            foreach ($this->clients as $key => $session) {
                try {
                    $session->handle();
                } catch (\Exception $e) {
                    self::getLogger()->error("Erreur lors du traitement de la session: " . $e->getMessage());
                    unset($this->clients[$key]);
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