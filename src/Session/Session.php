<?php

namespace Nirbose\PhpMcServ\Session;

use Nirbose\PhpMcServ\Entity\GameProfile;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Event\EventManager;
use Nirbose\PhpMcServ\Event\Player\PlayerJoinEvent;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Protocol;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Utils\MinecraftAES;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;
use Socket;

class Session
{
    public string $uuid;
    public string $username;
    public ServerState $state = ServerState::HANDSHAKE;
    public string $buffer = '';
    public int $lastKeepAliveId = 0;

    // Chiffrement AES-CFB8
    private bool $encryptionEnabled = false;
    private string $sharedSecret = '';
    private MinecraftAES $clientToServer;
    private MinecraftAES $serverToClient;

    // NOUVELLES PROPRIÉTÉS POUR STOCKER LES IVs ACTUELS
    private string $clientToServerIv;
    private string $serverToClientIv;

    public function __construct(
        private readonly Server $server,
        private readonly Socket $socket
    )
    {
    }

    public function sendPacket(Packet $packet): void
    {
        $serializer = new PacketSerializer();

        $serializer->putVarInt($packet->getId());
        $packet->write($serializer);

        $data = $serializer->get();

        $serializer = new PacketSerializer();

        $serializer->putVarInt(strlen($data));
        $length = $serializer->get();

        $raw = $length . $data;

        echo "Sending packet ID: " . dechex($packet->getId()) . " (len: " . bin2hex($length) . ", state: " . $this->state->name . ") with data: " . bin2hex($length . $data) . "\n";

        if ($this->encryptionEnabled) {
            // Passe l'IV actuel et récupère le nouvel IV ainsi que les données chiffrées.
            [$raw, $this->serverToClientIv] = $this->serverToClient->encrypt($raw, $this->serverToClientIv);
        }

        socket_write($this->socket, $raw);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function handle(): void
    {
        $offset = 0;

        try {
            while (true) {
                // AJOUTER CES LOGS ICI, AU DÉBUT DE LA BOUCLE
                Server::getLogger()->debug("Session::handle - Début de boucle. Offset actuel DANS LE BUFFER: " . $offset . ", Taille buffer TOTALE: " . strlen($this->buffer));
                Server::getLogger()->debug("Session::handle - Etat actuel: " . $this->state->name);
                // FIN DES NOUVEAUX LOGS

                $serializer = new PacketSerializer();
                $varintLength = 0;

                $packetLength = $serializer->tryReadVarInt($this->buffer, $offset, $varintLength);

                // AJOUTER CES LOGS ICI, APRÈS tryReadVarInt
                if ($packetLength === null) {
                    Server::getLogger()->debug("Session::handle - Pas assez de données pour la longueur du paquet. Sortie de boucle.");
                    break; // Pas assez de données dans le buffer pour lire la longueur entière du prochain paquet
                }
                Server::getLogger()->debug("Session::handle - Longueur VarInt lue pour le paquet (bytes): " . $varintLength . ", Longueur du paquet (hors VarInt, donnée par le VarInt): " . $packetLength);
                // FIN DES NOUVEAUX LOGS

                $totalLength = $varintLength + $packetLength; // Longueur totale du paquet ENCRYPTÉ dans le buffer

                // AJOUTER CES LOGS ICI, AVANT la vérification de strlen
                Server::getLogger()->debug("Session::handle - Longueur totale ENCRYPTÉE attendue dans le buffer (VarInt + données): " . $totalLength);
                // FIN DES NOUVEAUX LOGS

                if (strlen($this->buffer) < $offset + $totalLength) {
                    // Pas encore assez de données pour le paquet complet
                    Server::getLogger()->debug("Session::handle - Pas assez de données dans le buffer (" . strlen($this->buffer) . " octets) pour le paquet ENCRYPTÉ entier à l'offset " . $offset . ". Attendu: " . ($offset + $totalLength) . ". Sortie de boucle.");
                    break;
                }

                // Extraire le paquet complet
                $encryptedPacketData = substr($this->buffer, $offset, $totalLength);
                Server::getLogger()->debug("Session::handle - Données chiffrées extraites du buffer (hex): " . bin2hex($encryptedPacketData));
                $offset += $totalLength;

                $packetOffset = 0;
                $serializer = new PacketSerializer();

                // Skip la longueur VarInt
                $serializer->getVarInt($encryptedPacketData, $packetOffset); // IMPORTANT : C'est le VarInt du paquet DÉCHIFFRÉ !

                $packetId = $serializer->getVarInt($encryptedPacketData, $packetOffset);
                // AJOUTER CE LOG ICI, APRÈS LA LECTURE DE L'ID
                Server::getLogger()->debug("Session::handle - ID du paquet DÉCHIFFRÉ lu: 0x" . dechex($packetId));
                // FIN DU NOUVEAU LOG

                $packetMap = Protocol::PACKETS[$this->state->value] ?? [];
                $packetClass = $packetMap[$packetId] ?? null;

                if ($packetClass === null) {
                    throw new \Exception("Paquet inconnu ID=$packetId dans l'état {$this->state->name} avec le buffer: " . bin2hex($encryptedPacketData));
                }

                /** @var Packet $packet */
                $packet = new $packetClass();
                $packet->read($serializer, $encryptedPacketData, $packetOffset); // Ici, utilisez les données déjà déchiffrées
                Server::getLogger()->debug("Session::handle - Paquet " . get_class($packet) . " lu. Offset après lecture: " . $packetOffset . "/" . strlen($encryptedPacketData));
                $packet->handle($this);
                Server::getLogger()->debug("Session::handle - Paquet " . get_class($packet) . " géré.");
            }

            // Conserver les données restantes
            $this->buffer = substr($this->buffer, $offset);
        } catch (\Exception $e) {
            echo "Erreur: " . $e->getMessage() . "\n";
            echo $e->getTraceAsString();
            $this->close();
        }
    }

    /**
     * Set the session state.
     *
     * @param ServerState|int $state
     * @return void
     */
    public function setState(ServerState|int $state): void
    {
        if (is_int($state)) {
            $state = ServerState::from($state);
        }

        echo "Changement d'état de {$this->state->name} à {$state->name}\n";

        if ($state === ServerState::PLAY) {
            $player = $this->createPlayer();

            $event = EventManager::call(
                new PlayerJoinEvent($player)
            );

            if (!$event->isCancelled()) {
                $this->server->addPlayer($player);
            }
        }

        $this->state = $state;
    }

    /**
     * Create new player
     *
     * @return Player
     */
    private function createPlayer(): Player
    {
        return new Player(
            $this,
            new GameProfile($this->username, UUID::fromString($this->uuid)),
            new Location(0, 0, 0)
        );
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * Add data
     *
     * @param string $data
     * @return void
     */
    public function addToBuffer(string $data): void
    {
        if ($this->encryptionEnabled) {
            // Passe l'IV actuel et récupère le nouvel IV ainsi que les données déchiffrées.
            // METTRE EN PLACE LES LOGS POUR DÉBUGGER LES CRASHS ICI SI IL Y EN A UN
            echo "addToBuffer - Données chiffrées reçues: " . bin2hex($data) . PHP_EOL; // Log des données chiffrées avant déchiffrement
            echo "addToBuffer - IV clientToServer avant déchiffrement: " . bin2hex($this->clientToServerIv) . PHP_EOL; // Log de l'IV avant déchiffrement
            [$data, $this->clientToServerIv] = $this->clientToServer->decrypt($data, $this->clientToServerIv);
            echo "data (déchiffrée): " . bin2hex($data) . PHP_EOL; // Log des données déchiffrées
            echo "addToBuffer - IV clientToServer après déchiffrement (nouveau): " . bin2hex($this->clientToServerIv) . PHP_EOL; // Log du nouvel IV
        }

        echo "buffer (avant concaténation): " . bin2hex($this->buffer) . PHP_EOL;
        $this->buffer .= $data;
        echo "buffer (après concaténation): " . bin2hex($this->buffer) . PHP_EOL;
    }

    public function enableEncryption(string $sharedSecret): void
    {
        if ($this->encryptionEnabled) {
            echo "⚠️ Chiffrement déjà activé\n";
            return;
        }

        $this->encryptionEnabled = true;
        $this->sharedSecret = $sharedSecret;

        // Initialise les IVs avec le sharedSecret (rempli à 16 octets si nécessaire)
        $initialIv = str_pad(substr($sharedSecret, 0, 16), 16, "\0");
        $this->clientToServerIv = $initialIv;
        $this->serverToClientIv = $initialIv;

        // Le constructeur de MinecraftAES ne prend plus l'IV
        $this->clientToServer = new MinecraftAES($sharedSecret);
        $this->serverToClient = new MinecraftAES($sharedSecret);

        echo "🔐 Chiffrement AES-128-CFB8 activé\n";
    }

    public function disableEncryption(): void
    {
        $this->encryptionEnabled = false;
        $this->sharedSecret = '';

        echo "🔓 Chiffrement désactivé\n";
    }
}