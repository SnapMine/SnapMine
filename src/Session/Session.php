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
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\Utils\UUID;
use Socket;

class Session
{
    public string $uuid;
    public string $username;
    public ServerState $state;
    public string $buffer = '';
    public int $lastKeepAliveId = 0;
    
    public function __construct(
        private readonly Server $server,
        private readonly Socket $socket
    )
    {
        $this->state = ServerState::HANDSHAKE;
    }

    public function sendPacket(Packet $packet): void {
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

    public function close(): void {
        socket_close($this->socket);
    }

    public function handle(): void {
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
     * Set the session state.
     * 
     * @param ServerState|int $state
     * @return void
     */
    public function setState(ServerState|int $state): void {
        if (is_int($state)) {
            $state = ServerState::from($state);
        }

        echo "Changement d'état de {$this->state->name} à {$state->name}\n";

        if ($state === ServerState::PLAY) {
            $player = new Player($this, new GameProfile($this->username, UUID::fromString($this->uuid)));

            $event = EventManager::call(
                new PlayerJoinEvent($player)
            );

            if (!$event->isCancelled()) {
                $this->server->addPlayer($player);
            }
        }

        $this->state = $state;
    }

    public function getServer()
    {
        return $this->server;
    }
}