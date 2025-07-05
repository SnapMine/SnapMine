<?php

namespace Nirbose\PhpMcServ\Session;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Protocol;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Utils\MinecraftAES;
use Nirbose\PhpMcServ\Server;
use Socket;

class Session
{
    public string $uuid;
    public string $username;
    public ServerState $state;
    public string $buffer = '';
    public int $lastKeepAliveId = 0;

    // Chiffrement AES-CFB8
    private bool $encryptionEnabled = false;
    private string $sharedSecret = '';
    private MinecraftAES $encryptCipher;
    private MinecraftAES $decryptCipher;

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

        // echo "Sending packet ID: " . dechex($packet->getId()) . " (len: " . bin2hex($length) . ") with data: " . bin2hex($length . $data) . "\n";

        socket_write($this->socket, $length . $data);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function handle(): void
    {
        $offset = 0;

        try {
            while (strlen($this->buffer) > $offset) {
                $lengthSerializer = new PacketSerializer();
                $packetLength = $lengthSerializer->getVarInt($this->buffer, $offset);

                if (strlen($this->buffer) < $offset + $packetLength) {
                    // On attend encore le reste du paquet
                    break;
                }

                // Extraire juste les bytes du paquet
                $packetData = substr($this->buffer, $offset, $packetLength);
                $offset += $packetLength;

                $packetSerializer = new PacketSerializer();
                $packetOffset = 0;

                $packetId = $packetSerializer->getVarInt($packetData, $packetOffset);

                $packetMap = Protocol::PACKETS[$this->state->value] ?? [];
                $packetClass = $packetMap[$packetId] ?? null;

                if ($packetClass === null) {
                    throw new \Exception("Paquet inconnu ID=$packetId dans l'état {$this->state->name} avec le buffer: " . bin2hex($packetData));
                }

                /** @var Packet $packet */
                $packet = new $packetClass();
                $packet->read($packetSerializer, $packetData, $packetOffset);
                $packet->handle($this);
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
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * Ajoute des données au buffer (déchiffre si nécessaire)
     */
    public function addToBuffer(string $data): void {
        if ($this->encryptionEnabled) {
            $data = $this->decryptCipher->decrypt($data);
        }
        $this->buffer .= $data;
    }

    public function enableEncryption(string $sharedSecret): void
    {
        $this->encryptionEnabled = true;
        $this->sharedSecret = $sharedSecret;

        // Créer les chiffreurs avec le même secret comme clé ET IV
        $this->encryptCipher = new MinecraftAES($sharedSecret, $sharedSecret);
        $this->decryptCipher = new MinecraftAES($sharedSecret, $sharedSecret);

        echo "🔐 Chiffrement AES-128-CFB8 activé\n";
    }

    public function disableEncryption(): void
    {
        $this->encryptionEnabled = false;
        $this->sharedSecret = '';

        echo "🔓 Chiffrement désactivé\n";
    }
}