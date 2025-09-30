<?php

namespace SnapMine\Session;

use Exception;
use SnapMine\Entity\GameProfile;
use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Packet\Clientbound\Configuration\TransferPacket;
use SnapMine\Network\Packet\Clientbound\Play\TransferPacket as PlayTransferPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Protocol;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\ServerState;
use SnapMine\Server;
use SnapMine\Utils\UUID;
use SnapMine\World\Location;
use React\Socket\ConnectionInterface;

class Session
{
    public UUID $uuid;
    public string $username;
    public ServerState $state;
    public int $lastKeepAliveId = 0;
    private ?Player $player = null;

    public PacketSerializer $serializer;

    public function __construct(
        private readonly Server $server,
        private readonly ConnectionInterface $socket
    )
    {
        $this->state = ServerState::HANDSHAKE;

        $this->serializer = new PacketSerializer("");
    }

    public function sendPacket(ClientboundPacket $packet): bool
    {
        $serializer = new PacketSerializer("", 0);

        $serializer->putVarInt($packet->getId());
        $packet->write($serializer);

        // echo "Sending packet ID: " . dechex($packet->getId()) . " (len: " . bin2hex($length) . ") with data: " . bin2hex($length . $data) . "\n";
//        if ($this->socket == null || !is_resource($this->socket)) {
//            echo "Socket is not valid, cannot send packet.\n";
//            return;
//        }
        return $this->socket->write($serializer->getLengthPrefixedData());
    }

    public function close(?string $reason = null): void
    {
        $this->server->closeSession($this, $this->socket);
    }

    public function handle(): void
    {
        try {
            while (strlen($this->serializer->get()) > $this->serializer->getOffset()) {
                $initialOffset = $this->serializer->getOffset();

                if (strlen($this->serializer->get()) - $initialOffset < 1) {
                    break;
                }

                $packetLength = $this->serializer->getVarInt();

                if (strlen($this->serializer->get()) < $this->serializer->getOffset() + $packetLength) {
                    // Waiting for the rest of the packet
                    $this->serializer->setOffset($initialOffset);
                    break;
                }

                $packetData = $this->serializer->getNBytes($packetLength);
                $packetSerializer = new PacketSerializer($packetData);

                $packetId = $packetSerializer->getVarInt();

                $packetMap = Protocol::PACKETS[$this->state->value];
                $packetClass = $packetMap[$packetId] ?? null;

                if ($packetClass === null) {
                    // Handle unknown packet gracefully
                    echo "Paquet inconnu ID=$packetId dans l'état {$this->state->name}. Déconnexion du client.\n";
                    $this->close();
                    return;
                }

                /**
                 * @var ServerboundPacket $packet
                 * @phpstan-ignore varTag.nativeType
                 */
                $packet = new $packetClass();
                $packet->read($packetSerializer);
                $packet->handle($this);
                $this->serializer->clear();
            }

            $this->serializer->clear();
        } catch (Exception $e) {
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

        $this->state = $state;
    }

    /**
     * Create new player
     *
     * @return ?Player
     */
    private function createPlayer(): ?Player
    {
        if (empty($this->username) || empty($this->uuid)) {
            return null;
        }

        return new Player(
            $this,
            new GameProfile($this->username, UUID::fromString($this->uuid)),
            new Location($this->server->getWorld('world'), 0, 0, 0) // TODO: replace world by default world
        );
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @return ?Player
     */
    public function getPlayer(): ?Player
    {
        if ($this->player === null) {
            $this->player = $this->createPlayer();
        }

        return $this->player;
    }

    /**
     * @throws Exception
     */
    public function transfer(string $host, int $port): void
    {
        if ($this->state == ServerState::CONFIGURATION)
            $this->sendPacket(new TransferPacket($host, $port));
        else if ($this->state == ServerState::PLAY)
            $this->sendPacket(new PlayTransferPacket($host, $port));
        else
            throw new Exception('The server is currently not in the state of ServerState::CONFIGURATION or ServerState::PLAY');
    }
}
