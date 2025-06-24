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
    private static $keyResource = null;
    private static string $privateKeyPem = '';
    private static string $publicKeyDer = '';

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

        $this->generateRSAKeyPair();
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

                    echo "Paquet brut reçu (hex) : " . bin2hex($data) . "\n";

                    $session->addToBuffer($data);
                    $session->handle();
                }
            }
        }
    }

    private function generateRSAKeyPair(): void
    {
        if (self::$keyResource === null) {
            $config = [
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
                "private_key_bits" => 1024,
                "digest_alg" => "sha1"
            ];

            // Génération de la paire de clés
            self::$keyResource = openssl_pkey_new($config);
            if (!self::$keyResource) {
                throw new \RuntimeException("Impossible de générer la paire de clés RSA: " . openssl_error_string());
            }

            // Export de la clé privée en PEM
            if (!openssl_pkey_export(self::$keyResource, self::$privateKeyPem)) {
                throw new \RuntimeException("Impossible d'exporter la clé privée: " . openssl_error_string());
            }

            // Récupération de la clé publique
            $publicKeyDetails = openssl_pkey_get_details(self::$keyResource);
            if (!$publicKeyDetails) {
                throw new \RuntimeException("Impossible de récupérer les détails de la clé publique");
            }

            // Conversion de la clé publique PEM vers DER
            self::$publicKeyDer = self::pemToDer($publicKeyDetails['key']);
        }
    }

    public static function pemToDer(string $pem): string
    {
        $pem = preg_replace('/-----BEGIN PUBLIC KEY-----/', '', $pem);
        $pem = preg_replace('/-----END PUBLIC KEY-----/', '', $pem);
        $pem = str_replace(["\r", "\n"], '', $pem);
        return base64_decode($pem);
    }

    public static function getPublicKey(): ?string
    {
        return self::$publicKeyDer;
    }

    public static function getPrivateKey()
    {
        return self::$keyResource;
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